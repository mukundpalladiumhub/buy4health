<?php

class Category_model extends CI_Model {

    public $search;
    public $length;
    public $start;
    public $column;
    public $dire;

    public function __construct() {
        parent::__construct();
    }

    public function CategoryList($conn) {
        $this->db->select('*');
        $this->db->from('category');
        $search = $this->search;
        $length = $this->length;
        $start = $this->start;
        $column = $this->column;
        $dire = $this->dire;
        if (isset($search) && $search != '') {
            $this->db->like('category_name', $search);
            $this->db->or_like('category_description', $search);
            $this->db->or_like('category_tag', $search);
            $this->db->or_like('category_image', $search);
        }
        if (isset($column) && $column != '') {
            $this->db->order_by($column, $dire);
        }
        if ($conn == FALSE) {
            $nos = $this->db->get()->num_rows();
            return $nos;
        }
        if (isset($start) && $start != '') {
            $this->db->limit($length, $start);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getCategoryList() {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('status', 1);
        $resultQuery = $this->db->get();
        $resultCategoryList = $resultQuery->result_array();
        return $resultCategoryList;
    }

}

?>