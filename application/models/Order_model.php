<?php

class Order_model extends CI_Model {

    public $search;
    public $length;
    public $start;
    public $column;
    public $dire;

    public function __construct() {
        parent::__construct();
    }

    public function OrderList($conn) {
        $this->db->from('order as o');
        $this->db->join('user_details as ud', 'ud.id = o.user_id', 'left');
        $this->db->join('product as p', 'p.id = o.product_id', 'left');
        $this->db->select('o.*, ud.full_name, p.product_name');
        $search = $this->search;
        $length = $this->length;
        $start = $this->start;
        $column = $this->column;
        $dire = $this->dire;
        if (isset($search) && $search != '') {
            $this->db->like('p.product_name', $search);
            $this->db->or_like('ud.full_name', $search);
            $this->db->or_like('o.order_amount', $search);
            $this->db->or_like('o.transaction_id', $search);
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

    public function view($id) {
        $this->db->from('order o');
        $this->db->join('user_details ud', 'ud.id = o.user_id', 'left');
        $this->db->join('product p', 'p.id = o.product_id', 'left');
        $this->db->select('o.*, ud.full_name, p.product_name');
        $this->db->where('o.id', $id);
        $query = $this->db->get()->row();
        return $query;
    }

}

?>