<?php

class Product_model extends CI_Model {

    public $search;
    public $length;
    public $start;
    public $column;
    public $dire;
    public $category_id;
    public $sort;
    public $type;
    public $min;
    public $display_type;

    public function __construct() {
        parent::__construct();
    }

    public function ViewList($conn) {
        $this->db->from('product as p');
        $this->db->join('category as c', 'c.id = p.category', 'left');
        $this->db->select("p.*, c.category_name ,IF((SELECT SUM(quantity) FROM `product_price_details` WHERE product_id = p.id) > 0,'InStock','out Of Stock') as status");
        $this->db->where("p.status", 1);
        if (isset($this->category_id) && $this->category_id > 0) {
            $this->db->where("p.category", $this->category_id);
        }
        if (isset($this->display_type) && $this->display_type == 'Buy') {
            $this->db->where("p.site_id", BUY4HEALTHID);
        }
        if (isset($this->display_type) && $this->display_type == 'Rent') {
            $this->db->where("p.site_id", RENT4HEALTHID);
        }
        if (isset($this->sort) && $this->sort == 1) {
            $this->db->order_by("p.product_name", 'ASC');
        } else if (isset($this->sort) && $this->sort == 2) {
            $this->db->order_by("p.product_name", 'DESC');
        }

        if (isset($this->type) && $this->type == 1) {

            $this->db->where("p.product_type", $this->type);

            if (isset($this->min) && $this->min != "") {
                $this->db->where("p.avg_rent_price >=", $this->min);
            } 
            if (isset($this->max) && $this->max != "") {
                $this->db->where("p.avg_rent_price <=", $this->max);
            }
        } else if (isset($this->type) && $this->type == 2) {

            $this->db->where("p.product_type", $this->type);
            if (isset($this->min) && $this->min != "") {
                $this->db->where("p.avg_sale_price >=", $this->min);
            } 
            if (isset($this->max) && $this->max != "") {
                $this->db->where("p.avg_sale_price <=", $this->max);
            }
        } else if (isset($this->type) && $this->type == 3) {

            $this->db->where("p.product_type", $this->type);
            
            if (isset($this->min) && $this->min != "") {
                $this->db->where("p.avg_rent_price >=", $this->min);
                $this->db->where("p.avg_sale_price >=", $this->min);
            } 
            if (isset($this->max) && $this->max != "") {
                $this->db->where("p.avg_rent_price <=", $this->max);
                $this->db->where("p.avg_sale_price <=", $this->max);
            }

        }


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

    /*public function FilterList($conn, $sort, $filter, $max, $min) {
        $this->db->from('product as p');
        $this->db->join('category as c', 'c.id = p.category', 'left');
        $this->db->select("p.*, c.category_name ,IF(p.status = 1,'Active','Inactive') as status");
        if ($filter == 1) {
            $this->db->like('p.product_type', 2);   //Filter Buy column
            if (isset($min) && $min != '' && isset($max) && $max != '') {
                $this->db->where('p.avg_sale_price >=', $min);  //Filter by Sale_price
                $this->db->where('p.avg_sale_price <=', $max);
            }
        } elseif ($filter == 2) {
            $this->db->like('p.product_type', 2);   //Filter Rent column
            if (isset($min) && $min != '' && isset($max) && $max != '') {
                $this->db->where('p.avg_rent_price >=', $min);  //Filter by Rent_price
                $this->db->where('p.avg_rent_price <=', $max);
            }
        } else {
            //All
            if (isset($min) && $min != '' && isset($max) && $max != '') {
                $this->db->where('p.avg_sale_price >=', $min);  //Filter
                $this->db->where('p.avg_sale_price <=', $max);
                $this->db->where('p.avg_rent_price >=', $min);  //Filter by Rent_price
                $this->db->where('p.avg_rent_price <=', $max);
            }
        }

        if ($conn == FALSE) {
            $result = $this->db->get();
            return $result->num_rows();
        } else {
            if ($sort == 2) {
                $this->db->order_by('p.product_name', "DESC");  //Z to A
            } else {
                $this->db->order_by('p.product_name', "ASC");   //A to Z
            }
            $this->db->limit($this->length, $this->start);
            $result = $this->db->get();
            $str = $this->db->last_query();
            return $result->result_array();
        }
    }*/

    public function Productview($id) {
        $this->db->from('product as p');
        $this->db->join('category as c', 'c.id = p.category', 'left');
        $this->db->join('product_images as pi', 'pi.product_id = p.id', 'left');
        $this->db->select('p.*, c.category_name, pi.product_image,IF(p.status = 1,"Active","Inactive") as status');
        $this->db->where('p.id', $id);
        $query = $this->db->get()->row();
        return $query;
    }

    public function ProductImageList($conn, $id) {
        $this->db->from('product_images as pi');
        $this->db->join('product as p', 'p.id = pi.product_id', 'left');
        $this->db->select("p.product_name,pi.product_image,pi.id");
        $this->db->where("pi.id", $id);
        if (isset($this->search) && $this->search != '') {
            $this->db->group_start()
                    ->like('p.product_name', $this->search)
                    ->or_like('pi.product_image', $this->search)
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

    public function price($id) {
        $this->db->from('product_price_details as pp');
        $this->db->join('product as p', 'p.id = pp.product_id', 'left');
        $this->db->select('pp.*, p.product_name');
        $this->db->where('pp.id', $id);
        $query = $this->db->get()->row();
        return $query;
    }

    public function ProductPriceList($conn, $id) {
        $this->db->from('product_price_details as pp');
        $this->db->join('product as p', 'p.id = pp.product_id', 'left');
        $this->db->select("p.product_name,pp.*,IF(p.status = 1,'Active','Inactive') as status");
        $this->db->where("pp.id", $id);
        if (isset($this->search) && $this->search != '') {
            $this->db->group_start()
                    ->like('pp.size_type', $this->search)
                    ->or_like('pp.size_id', $this->search)
                    ->or_like('pp.quantity', $this->search)
                    ->or_like('pp.low_level', $this->search)
                    ->or_like('pp.service_tax', $this->search)
                    ->or_like('pp.mrp', $this->search)
                    ->or_like('pp.price', $this->search)
                    ->or_like('pp.status', $this->search)
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

    public function rent($id) {
        $this->db->from('product_rent_details as pr');
        $this->db->join('product as p', 'p.id = pr.product_id', 'left');
        $this->db->select('pr.*, p.product_name');
        $this->db->where('pr.id', $id);
        $query = $this->db->get()->row();
        echo "<pre>";
        print_r($query);
        die;
        return $query;
    }

    public function getProductListbyid($id) {
        $this->db->from('product as p');
        $this->db->join('product_price_details as ppd', 'ppd.product_id = p.id', 'left');
        $this->db->select("p.*,IF(ppd.quantity > 0,'InStock','out Of Stock') as status");
        $this->db->where('p.status', 1);
        $this->db->where('p.id', $id);
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
        $resultProductPrice = $resultQuery->result_array();
        return $resultProductPrice;
    }

    public function getProductRent($id) {
        $this->db->select('*');
        $this->db->from('product_rent_details');
        $this->db->where('status', 1);
        $this->db->where('product_id', $id);
        $resultQuery = $this->db->get();
        $resultProductRent = $resultQuery->result_array();
        return $resultProductRent;
    }
    
    public function getProductName($id) {
        $this->db->select('id,product_name,product_code');
        $this->db->from('product');
        $this->db->where('id', $id);
        $resultQuery = $this->db->get();
        return $resultQuery->row_array();
    }

}

?>