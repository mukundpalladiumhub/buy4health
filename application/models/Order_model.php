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

        $this->db->from('orders as o');
        $this->db->join('users as u', 'u.id = o.user_id', 'left');
        $this->db->select("o.*, u.first_name, u.last_name,IF(o.status = 1,'Active','Inactive') as status");

        if (isset($this->search) && $this->search != '') {
            $this->db->group_start()
                    ->like('u.first_name', $this->search)
                    ->or_like('u.last_name', $this->search)
                    ->or_like('o.order_number', $this->search)
                    ->or_like('o.order_delivery_charge', $this->search)
                    ->or_like('o.total', $this->search)
                    ->or_like('o.convenience_charge', $this->search)
                    ->or_like('o.shipping_rate', $this->search)
                    ->or_like('o.order_date', $this->search)
                    ->or_like('o.payment_method', $this->search)
                    ->or_like('o.payment_status', $this->search)
                    ->or_like('o.order_status', $this->search)
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

    public function OrderDetailList($conn, $id) {

        $this->db->from('order_details as od');
        $this->db->join('orders as o', 'o.order_id = od.order_id', 'left');
        $this->db->join('product as p', 'p.id = od.product_id', 'left');
        $this->db->join('size as s', 's.id = od.size_id', 'left');
        $this->db->select("od.*, p.product_name,s.size,o.order_number,IF(od.status = 1,'Active','Inactive') as status");
        $this->db->where("od.order_id", $id);


        if (isset($this->search) && $this->search != '') {
            $this->db->group_start()
                    ->like('p.product_name', $this->search)
                    ->or_like('s.size', $this->search)
                    ->or_like('od.type', $this->search)
                    ->or_like('od.quantity', $this->search)
                    ->or_like('od.price', $this->search)
                    ->or_like('od.total_price', $this->search)
                    ->or_like('od.rent_duration', $this->search)
                    ->or_like('od.delivery_charge', $this->search)
                    ->or_like('od.advance_amount', $this->search)
                    ->or_like('od.refund_amount', $this->search)
                    ->or_like('od.damage_amount', $this->search)
                    ->or_like('od.deliver_on', $this->search)
                    ->or_like('od.delivery_date', $this->search)
                    ->or_like('od.pickup_date', $this->search)
                    ->or_like('od.commison', $this->search)
                    ->or_like('o.order_number', $this->search)
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