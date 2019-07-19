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

    public function ViewList($conn) {
        $this->db->from('product as p');
        $this->db->join('category as c', 'c.id = p.category', 'left');
        $this->db->select("p.*, c.category_name ,IF(p.status = 1,'Active','Inactive') as status");

        if (isset($this->search) && $this->search != '') {
            $this->db->group_start()
                    ->like('p.product_type', $this->search)
                    ->or_like('p.product_code', $this->search)
                    ->or_like('p.product_name', $this->search)
                    ->or_like('c.category_name', $this->search)
                    ->or_like('p.sub_category', $this->search)
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
        $this->db->from('product as p');
        $this->db->join('category as c', 'c.id = p.category', 'left');
        $this->db->select('p.*, c.category_name');
        $this->db->where('p.id', $id);
        $query = $this->db->get()->row();
        return $query;
    }

    public function getProductListbyid($id) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('status', 1);
        $this->db->where('id', $id);
        $resultQuery = $this->db->get();
        $resultProductList = $resultQuery->result_array();
        return $resultProductList;
    }

    public function getProductImage($id) {
        $this->db->select('*');
        $this->db->from('product_images');
        $this->db->where('status', 1);
        $this->db->where('product_id', $id);
        $resultQuery = $this->db->get();
        $resultProductImages = $resultQuery->result_array();
        return $resultProductImages;
    }

    public function getProductPrice($id) {
        $this->db->select('*');
        $this->db->from('product_price_details');
        $this->db->where('status', 1);
        $this->db->where('product_id', $id);
        $resultQuery = $this->db->get();
        $resultProductPrice = $resultQuery->row_array();
        return $resultProductPrice;
    }

    public function getProductRent($id) {
        $this->db->select('*');
        $this->db->from('product_rent_details');
        $this->db->where('status', 1);
        $this->db->where('product_id', $id);
        $resultQuery = $this->db->get();
        $resultProductRent = $resultQuery->row_array();
        return $resultProductRent;
    }

}

?>