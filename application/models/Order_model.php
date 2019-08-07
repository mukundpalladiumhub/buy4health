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
        $this->db->join('order_status as os', 'os.status_id = o.order_status', 'left');
        $this->db->select("o.*, u.first_name, os.status_name, u.last_name,IF(o.status = 1,'Active','Inactive') as status");

        if (isset($this->search) && $this->search != '') {
            $this->db->group_start()
                    ->like('u.first_name', $this->search)
                    ->or_like('u.last_name', $this->search)
                    ->or_like('o.order_number', $this->search)
                    ->or_like('o.total', $this->search)
                    ->or_like('o.order_date', $this->search)
                    ->or_like('os.status_name', $this->search)
                    ->group_end();
        }

        if ($conn == FALSE) {
            $result = $this->db->get();
            return $result->num_rows();
        } else {
            if (isset($this->column) && $this->column != '') {
                $this->db->order_by($this->column, $this->dire);
            } else {
                $this->db->order_by('order_id', 'DESC');
            }

            $this->db->limit($this->length, $this->start);
            $result = $this->db->get();
            return $result->result_array();
        }
    }

    public function OrderDetailList($conn, $id) {

        $this->db->from('order_details as od');
//        $this->db->join('orders as o', 'o.order_id = od.order_id', 'left');
        $this->db->join('product as p', 'p.id = od.product_id', 'left');
        $this->db->join('size as s', 's.id = od.size_id', 'left');
        $this->db->select("od.*, p.product_name,s.size,IF(od.status = 1,'Active','Inactive') as status");
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
//                    ->or_like('o.order_number', $this->search)
                    ->group_end();
        }

        if ($conn == FALSE) {
            $result = $this->db->get();
            return $result->num_rows();
        } else {
            if (isset($this->column) && $this->column != '') {
                $this->db->order_by($this->column, $this->dire);
            }

//            $this->db->limit($this->length, $this->start);
            $result = $this->db->get();
            return $result->result_array();
        }
    }

    public function update_status($order_status, $id) {
        $this->db->set('order_status', $order_status);
        $this->db->where('order_id', $id);
        return $this->db->update('orders');
    }

    public function get_order_status() {
        $data = $this->db->select('*')
                        ->from('order_status')
                        ->where('status', 1)
                        ->get()->result_array();
        return $data;
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

    public function getProductUser($id) {
        $this->db->from('orders o');
        $this->db->join('users as u', 'u.id = o.user_id', 'left');
        $this->db->select('u.*, o.order_number,o.order_date,o.order_delivery_charge,o.total,o.shipping_rate');
        $this->db->where('o.order_id', $id);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function OrderDetailList_print($id) {
        $this->db->from('order_details as od');
//        $this->db->join('orders as o', 'o.order_id = od.order_id', 'left');
        $this->db->join('product as p', 'p.id = od.product_id', 'left');
        $this->db->join('size as s', 's.id = od.size_id', 'left');
        $this->db->select("od.*, p.product_name");
        $this->db->where("od.order_id", $id);
        $this->db->order_by('od.deliver_on', 'ASC');
        $result = $this->db->get()->result_array();
        return $result;
    }

}

?>