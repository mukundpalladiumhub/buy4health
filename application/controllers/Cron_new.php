<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_new extends CI_Controller {

    public function __construct() {
        parent::__construct();

        define('BUY4HEALTH', 2);
    }

    public function index() {

        $url = "https://www.buy4health.com/wp/wp-json/wc/v3/products/categories";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:' . AUTHORIZATION_TOKEN));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_exec($ch);
        $category_list = json_decode(curl_exec($ch), true);
        curl_close($ch);


        if (!empty($category_list)) {

            foreach ($category_list as $key => $category_value) {

                if (!empty($category_value['image'])) {

                    if (isset($category_value['image']['src']) && $category_value['image']['src'] != "") {

                        $pathinfo = pathinfo($category_value['image']['src']);

                        if (!empty($pathinfo)) {

                            $image_name = str_replace(' ', '%20', $pathinfo['basename']);
                            $path = 'assets/uploads/category/' . $pathinfo['basename'];
                            $myfile = file_get_contents('https://www.rent4health.com/uploads/product_images/' . $image_name);
                            $uploadfile = file_put_contents($path, $myfile);

                            $category_data['category_image'] = $pathinfo['basename'];
                        }
                    }
                }
                
                $category_id_check_product = $category_value['id'];

                $category_data['category_name'] = $category_value['name'];
                $category_data['category_description'] = $category_value['description'];
                $category_data['category_tag'] = '';
                $category_data['status'] = '';

                $check_category_exist = $this->db->select('category_name,id')->where("category_name", $category_value['name'])->get('category')->row_array();

                if (empty($check_category_exist)) {
                    $this->db->insert('category', $category_data);
                    $category_id = $this->db->insert_id();
                } else {
                    $category_id = $check_category_exist['id'];
                    $this->db->where('id', $check_category_exist['id']);
                    $this->db->update('category', $category_data);
                }
            }








            /*             * ***** For Product ****** */


            echo $url = "https://www.buy4health.com/wp/wp-json/wc/v3/products/";
//                    .$category_id_check_product;
            echo "<br>";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HEADER, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:' . AUTHORIZATION_TOKEN));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_exec($ch);
            $products = json_decode(curl_exec($ch), true);
            curl_close($ch);

            echo '<pre>';
            print_r($products);
            exit;



//            $products = $otherdb->select('*')
//                    ->from('product')
//                    ->where('category', $category_id_check_product)
//                    ->get()
//                    ->result_array();

//            if (!empty($products)) {
//
//                foreach ($products as $product_value) {
//
//                    $check_product_exist = $this->db->select('product_code,id')
//                                    ->where("product_code", $product_value['product_code'])
//                                    ->where("product_name", $product_value['product_name'])
//                                    ->where("site_id", RENT4HEALTH)
//                                    ->where('category', $category_id)
//                                    ->get('product')->row_array();
//
//                    $product_id_live_db = $product_value['id'];
//                    unset($product_value['id']);
//
//                    $product_value['site_id'] = RENT4HEALTH;
//                    $product_value['category'] = $category_id;
//
//                    if (empty($check_product_exist)) {
//                        $this->db->insert('product', $product_value);
//                        $product_id = $this->db->insert_id();
//                    } else {
//                        $product_id = $check_product_exist['id'];
//                        $this->db->where('id', $check_product_exist['id']);
//                        $this->db->update('product', $product_value);
//                    }
//
//
//                    /*                     * ***** For Product Images ****** */
//                    $product_images = $otherdb->select('*')
//                                    ->where('product_id', $product_id_live_db)
//                                    ->get('product_images')->result_array();
//
//                    if (!empty($product_images)) {
//
//                        foreach ($product_images as $productImg_value) {
//
//                            $check_productImg_exist = $this->db->select('product_image,id')
//                                            ->where("product_image", $productImg_value['product_image'])
//                                            ->where('product_id', $product_id)
//                                            ->get('product_images')->row_array();
//
//                            if (isset($productImg_value['product_image']) && $productImg_value['product_image'] != "") {
//
//                                $image_name = str_replace(' ', '%20', $productImg_value['product_image']);
//                                $path = 'assets/uploads/product/' . $productImg_value['product_image'];
//                                $myfile = file_get_contents('https://www.rent4health.com/uploads/product_images/' . $image_name);
//                                $uploadfile = file_put_contents($path, $myfile);
//                            }
//
//                            unset($productImg_value['id']);
//                            $productImg_value['product_id'] = $product_id;
//
//                            if (empty($check_productImg_exist)) {
//                                $this->db->insert('product_images', $productImg_value);
//                            } else {
//                                $this->db->where('id', $check_productImg_exist['id']);
//                                $this->db->update('product_images', $productImg_value);
//                            }
//                        }
//                    }
//                    /*                     * ***** End Product Images ****** */
//
//
//                    /*                     * ***** For Product Price ****** */
//                    $product_price = $otherdb->select('p.*,st.size_type as size_type_name,st.status as size_type_status,s.size as size_size,s.status as size_status')
//                            ->from('product_price_details as p')
//                            ->where('product_id', $product_id_live_db)
//                            ->join('size_type st', 'st.id = p.size_type', 'left')
//                            ->join('size s', 's.id = p.size_id', 'left')
//                            ->get()
//                            ->result_array();
//
//                    if (!empty($product_price)) {
//
//                        foreach ($product_price as $productPrice_value) {
//
//                            $check_size_type = $this->db->select('*')
//                                            ->where('size_type', $productPrice_value['size_type_name'])
//                                            ->get('size_type')->row_array();
//
//
//                            if (empty($check_size_type)) {
//                                $size_type_data['size_type'] = $productPrice_value['size_type_name'];
//                                $size_type_data['status'] = $productPrice_value['size_type_status'];
//
//
//                                $this->db->insert('size_type', $size_type_data);
//                                $size_type_id = $this->db->insert_id();
//                            } else {
//                                $size_type_id = $check_size_type['id'];
//                            }
//
//
//                            $check_size = $this->db->select('*')
//                                            ->where('size_type', $size_type_id)
//                                            ->get('size')->row_array();
//
//
//                            if (empty($check_size)) {
//                                $size_data['size_type'] = $size_type_id;
//                                $size_data['size'] = $productPrice_value['size_size'];
//                                $size_data['status'] = $productPrice_value['size_status'];
//
//                                $this->db->insert('size', $size_data);
//                                $size_id = $this->db->insert_id();
//                            } else {
//                                $size_id = $check_size['id'];
//                            }
//
//
//                            $check_productPrice_exist = $this->db->select('*')
//                                    ->where('size_type', $size_type_id)
//                                    ->where('size_id', $size_id)
//                                    ->get('product_price_details')
//                                    ->row_array();
//
//
//                            unset($productPrice_value['id']);
//                            unset($productPrice_value['size_type_name']);
//                            unset($productPrice_value['size_type_status']);
//                            unset($productPrice_value['size_size']);
//                            unset($productPrice_value['size_status']);
//
//                            $productPrice_value['product_id'] = $product_id;
//
//                            if (empty($check_productPrice_exist)) {
//                                $this->db->insert('product_price_details', $productPrice_value);
//                            } else {
//                                $this->db->where('id', $check_productPrice_exist['id']);
//                                $this->db->update('product_price_details', $productPrice_value);
//                            }
//                        }
//                    }
//                    /*                     * ***** End Product Price ****** */
//                }
//            }
            /*             * ***** End Product ****** */
        }
    }

}
