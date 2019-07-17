<?php

class Product_model extends CI_Model {

    public $search;
    public $length;
    public $start;
    public $column;
    public $dire;

    public function __construct() {
        parent::__construct();
    }

    public function show($conn) {
        $this->db->select('*');
        $this->db->from('product');
        if ($conn == FALSE) {
            $nos = $this->db->get()->num_rows();
            return $nos;
        } else {
            $search = $this->search;
            $length = $this->length;
            $start = $this->start;
            $column = $this->column;
            $dire = $this->dire;
            if (isset($search) && $search != '') {
                $this->db->like('title', $search);
                $this->db->or_like('description', $search);
                $this->db->or_like('price', $search);
            }
            if (isset($column) && $column != '') {
                $this->db->order_by($column, $dire);
            }
            if (isset($start) && $start != '') {
                $this->db->limit($length, $start);
            }
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function fill($id) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('id', $id);
        $query = $this->db->get()->row();
        return $query;
    }

}

?>