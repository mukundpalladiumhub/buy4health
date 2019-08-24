<?php

class Dashboard_model extends CI_Model {

    public $search;
    public $length;
    public $start;
    public $column;
    public $dire;

    public function __construct() {
        parent::__construct();
    }

    public function UserCounts() {
        $this->db->select('*');
        $this->db->from('category');
//        $this->db->where('status','1');
        $numbers['category_count'] = $this->db->get()->num_rows();
        $this->db->select('*');
        $this->db->from('product');
//        $this->db->where('status','1');
        $numbers['product_count'] = $this->db->get()->num_rows();
        $this->db->select('*');
        $this->db->from('orders');
//        $this->db->where('status','1');
        $numbers['orders_count'] = $this->db->get()->num_rows();
        
        return $numbers;
    }

    public function RecentOrders() {
        $query = $this->db->select('o.order_number,o.total,o.order_date,o.order_id,u.first_name,u.last_name,os.status_name')
                        ->from('orders as o')
                        ->join('users as u', 'u.id = o.user_id', 'LEFT')
                        ->join('order_status as os', 'os.status_id = o.order_status', 'left')
                        ->order_by('o.order_id', "desc")->limit(10)
                        ->get()->result_array();
        return $query;
    }

}

?>