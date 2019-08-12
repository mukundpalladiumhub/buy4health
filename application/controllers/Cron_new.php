<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_new extends CI_Controller {

    public function __construct() {
        parent::__construct();

        define('BUY4HEALTH', 2);
    }

    public function index() {

        $otherdb = $this->load->database('db_buy4health', TRUE);

        $category = $otherdb->select('wt.*,wtt.description')
                ->from('wp_terms as wt')
                ->join('wp_term_taxonomy as wtt', 'wtt.term_id = wt.term_id', 'left')
                ->where('wtt.taxonomy', 'product_cat')
                ->get()
                ->result_array();

//        $product_price = $otherdb->select('pm.*')
//                ->from('wp_posts as p')
//                ->join('wp_postmeta as pm', 'pm.post_id = p.ID', 'left')
//                ->where('p.ID', 82)
//                ->group_start()
//                ->where('pm.meta_key', '_price')
//                ->or_where('pm.meta_key', '_regular_price')
//                ->group_end()
//                ->get()
//                ->result_array();
//        
////        echo $otherdb->last_query();
////        exit;
//        
//

        /*         * ***** For Category ****** */
        if (!empty($category)) {

            foreach ($category as $category_value) {

                $check_category_exist = $this->db->select('category_name,id')->where("category_name", $category_value['name'])->get('category')->row_array();

                $category_id_check_product = $category_value['term_id'];
//                unset($category_value['id']);

                $category_data['category_name'] = isset($category_value['name']) ? $category_value['name'] : "";
                $category_data['category_description'] = isset($category_value['description']) ? $category_value['description'] : "";
                $category_data['status'] = 1;

                if (empty($check_category_exist)) {
                    $this->db->insert('category', $category_data);
                    $category_id = $this->db->insert_id();
                } else {
                    $category_id = $check_category_exist['id'];
                    $this->db->where('id', $check_category_exist['id']);
                    $this->db->update('category', $category_data);
                }

                $products = $otherdb->select('*')
                        ->from('wp_posts as wp')
                        ->join('wp_term_relationships as wtr', 'wtr.object_id = wp.ID', 'inner')
                        ->join('wp_terms as wt', 'wt.term_id = wtr.term_taxonomy_id', 'inner')
                        ->where('post_type', 'product')
                        ->where('post_status', 'publish')
                        ->where('wtr.term_taxonomy_id', $category_id_check_product)
                        ->get()
                        ->result_array();

//                echo $otherdb->last_query();
//                
//                
//                echo '<pre>';
//                print_r($products);
//                die;

                if (!empty($products)) {

                    foreach ($products as $product_value) {

                        $check_product_exist = $this->db->select('product_code,id')
//                                        ->where("product_code", $product_value['product_code'])
                                        ->where("product_name", $product_value['post_title'])
                                        ->where("site_id", BUY4HEALTH)
                                        ->where('category', $category_id)
                                        ->get('product')->row_array();

                        $product_id_live_db = $product_value['ID'];
//                        unset($product_value['id']);

                        $product_data['site_id'] = BUY4HEALTH;
                        $product_data['product_type'] = "";
                        $product_data['product_code'] = "";
                        $product_data['vendor_id'] = "";
                        $product_data['product_name'] = isset($product_value['post_title']) ? $product_value['post_title'] : "";
                        $product_data['brand '] = "";
                        $product_data['category'] = $category_id;
                        $product_data['sub_category'] = "";
                        $product_data['sub_sub_category'] = "";
                        $product_data['sub_sub_minor_category'] = "";
                        $product_data['product_description'] = isset($product_value['post_content']) ? $product_value['post_content'] : "";
                        $product_data['product_info'] = "";
                        $product_data['product_weight'] = "";
                        $product_data['product_tags'] = "";
                        $product_data['product_vat'] = "";
                        $product_data['service_tax'] = "";
                        $product_data['delivery_charges'] = "";
                        $product_data['cod_amount'] = "";
                        $product_data['packing_charges'] = "";
                        $product_data['size_type'] = "";
                        $product_data['vehicle'] = "";
                        $product_data['cod'] = "";
                        $product_data['sale_dispatch_time'] = "";
                        $product_data['meta_title'] = "";
                        $product_data['meta_keyword'] = "";
                        $product_data['meta_description'] = "";
                        $product_data['amazon_price'] = "";
                        $product_data['flipkart_price'] = "";
                        $product_data['call_to_enquire'] = "";
                        $product_data['avg_rating'] = "";
                        $product_data['rent_del_pickup_charges'] = "";
                        $product_data['avg_sale_price'] = "";
                        $product_data['avg_rent_price'] = "";
                        $product_data['refill_product_id'] = "";
                        $product_data['products_bought_together'] = "";
                        $product_data['status'] = "";

                        if (empty($check_product_exist)) {
                            $this->db->insert('product', $product_data);
                            $product_id = $this->db->insert_id();
                        } else {
                            $product_id = $check_product_exist['id'];
                            $this->db->where('id', $check_product_exist['id']);
                            $this->db->update('product', $product_data);
                        }


//                        $product_price = $otherdb->select('pm.*')
//                                ->from('wp_posts as p')
//                                ->join('wp_postmeta as pm', 'pm.post_id = p.ID', 'left')
//                                ->where('pm.meta_key', '_price')
//                                ->or_where('pm.meta_key', '_thumbnail_id')
//                                ->where('p.ID', 69)
////                                ->where('p.ID', $product_id_live_db)
//                                ->get()
//                                ->result_array();

                        $product_price = $otherdb->select('pm.*')
                                ->from('wp_postmeta as pm')
                                ->join('wp_posts as p', 'p.ID = pm.post_id', 'left')
                                ->where('pm.post_id', 69)
                                ->group_start() // Open bracket
                                ->where('pm.meta_key', '_price')
                                ->or_where('pm.meta_key', '_thumbnail_id')
                                ->group_end()
//                                ->where('p.ID', $product_id_live_db)
                                ->get()
                                ->result_array();

                        echo $otherdb->last_query();

                        echo '<pre>';
                        print_r($product_price);
                        die;
                    }
                }


//                echo '<pre>';
//                print_r($product);
//                die;
//                SELECT * FROM `wp_posts` as post INNER JOIN wp_term_relationships rs ON rs.object_id = post.ID 
//                    INNER JOIN wp_terms t ON t.term_id = rs.term_taxonomy_id WHERE `post_type` = "product" AND `post_status` = "publish" AND 
//                        rs.term_taxonomy_id = 15 ORDER BY post_date DESC LIMIT 5 
            }
        }

        echo '<pre>';
        print_r($category_data);
        die;


//        SELECT wp_terms.*
//        FROM wp_terms
//        LEFT JOIN wp_term_taxonomy ON wp_terms.term_id = wp_term_taxonomy.term_id
//        WHERE wp_term_taxonomy.taxonomy = 'product_cat';
    }

}
