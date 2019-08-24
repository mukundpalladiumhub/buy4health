<?php

class Category_model extends CI_Model {

    public $search;
    public $length;
    public $start;
    public $column;
    public $dire;
    public $site_id;

    public function __construct() {
        parent::__construct();
    }

    public function CategoryList($conn) {

        $this->db->select("*,IF(status = 1,'Active','Inactive') as status");
        $this->db->from('category');

        if (isset($this->site_id) && $this->site_id != "") {
            $this->db->where('site_id', $this->site_id);
        }

        if (isset($this->search) && $this->search != '') {
            $this->db->group_start()->like("category_name", $this->search)
                    ->or_like("category_description", $this->search)
                    ->or_like("category_tag", $this->search)
                    ->group_end();
        }

        if ($conn == FALSE) {
            $result = $this->db->get();
            return $result->num_rows();
        } else {
            if (isset($this->column) && $this->column != '') {
                $this->db->order_by($this->column, $this->dire);
            }

            $this->db->limit($this->length, $this->start);
            $result = $this->db->get();
            return $result->result_array();
        }
    }

    public function getCategoryList($display_type) {

        $this->db->select('*');
        $this->db->from('category');

        if (isset($display_type) && $display_type == "Buy") {
            $this->db->where('site_id', BUY4HEALTHID);
        }
        if (isset($display_type) && $display_type == "Rent") {
            $this->db->where('site_id', RENT4HEALTHID);
        }
//        $this->db->where('status', 1);
        $resultQuery = $this->db->get();
        $resultCategoryList = $resultQuery->result_array();
        return $resultCategoryList;
    }

}

?>