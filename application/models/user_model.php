<?php

class User_model extends CI_Model {

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
        $this->db->from('user_details');
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
                $this->db->like('full_name', $search);
                $this->db->or_like('user_name', $search);
                $this->db->or_like('password', $search);
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

}

?>