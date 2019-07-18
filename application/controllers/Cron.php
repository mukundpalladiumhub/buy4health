<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();

        define('RENT4HEALTH', 1);
    }

    public function index() {

        $otherdb = $this->load->database('otherdb', TRUE);

        $category = $otherdb->select('*')->get('category')->result_array();

        /*         * ***** For Category ****** */
        if (!empty($category)) {

            foreach ($category as $category_value) {

                $check_category_exist = $this->db->select('category_name,id')->where("category_name", $category_value['category_name'])->get('category')->row_array();

                unset($category_value['id']);

                if (empty($check_category_exist)) {

                    $this->db->insert('category', $category_value);
                } else {
                    $this->db->where('id', $check_category_exist['id']);
                    $this->db->update('category', $category_value);
                }
            }
        }
        /*         * ***** For Category ****** */


        /*         * ***** For Product ****** */
        $products = $otherdb->select('p.*,c.category_name')
                ->from('product as p')
                ->join('category as c', 'c.id = p.category', 'left')
                ->get()
                ->result_array();

        if (!empty($products)) {

            $category_names = $this->db->select('*')->get('category')->result_array();


            foreach ($category_names as $key => $cat_name) {
                $category_array[$cat_name['id']] = $cat_name['category_name'];
            }

            foreach ($products as $product_value) {

                $check_product_exist = $this->db->select('product_code,id')
                                ->where("product_code", $product_value['product_code'])
                                ->where("product_name", $product_value['product_name'])
                                ->where("site_id", RENT4HEALTH)
                                ->get('product')->row_array();

                unset($product_value['id']);
                $product_value['site_id'] = RENT4HEALTH;
                $product_value['category'] = array_search($product_value['category_name'], $category_array);
                unset($product_value['category_name']);

                if (empty($check_product_exist)) {
                    $this->db->insert('product', $product_value);
                } else {
                    $this->db->where('id', $check_product_exist['id']);
                    $this->db->update('product', $product_value);
                }
            }
        }
        /*         * ***** For Product ****** */


        /*         * ***** For Product Images ****** */
        /* $product_images = $otherdb->select('*')->get('product_images')->result_array();

          if (!empty($product_images)) {
          foreach ($product_images as $productImg_value) {

          $check_productImg_exist = $this->db->select('product_image,id')
          ->where("product_image", $productImg_value['product_image'])
          ->get('product_images')->row_array();


          if (isset($productImg_value['product_image']) && $productImg_value['product_image'] != "") {

          $image_name = str_replace(' ', '%20', $productImg_value['product_image']);
          $path = 'assets/product_image/' . $productImg_value['product_image'];
          $myfile = file_get_contents('https://www.rent4health.com/uploads/product_images/' . $image_name);
          $uploadfile = file_put_contents($path, $myfile);
          }

          unset($productImg_value['id']);
          if (empty($check_productImg_exist)) {
          $this->db->insert('product_images', $productImg_value);
          } else {
          $this->db->where('id', $check_productImg_exist['id']);
          $this->db->update('product_images', $productImg_value);
          }
          }
          } */
        /*         * ***** For Product Images ****** */


        /*         * ***** For Product Price ****** */
        /* $product_price_detail = $otherdb->select('*')->get('product_price_details')->result_array();

          if (!empty($product_price_detail)) {
          foreach ($product_price_detail as $product_price) {

          $check_product_exist = $this->db->select('product_code,id')
          ->where("product_code", $product_value['product_code'])
          ->where("site_id", RENT4HEALTH)
          ->get('product')->row_array();

          unset($product_value['id']);
          $product_value['site_id'] = RENT4HEALTH;

          if (empty($check_product_exist)) {
          $this->db->insert('product', $product_value);
          } else {
          $this->db->where('id', $check_product_exist['id']);
          $this->db->update('product', $product_value);
          }
          }
          } */
        /*         * ***** For Product Price ****** */
    }

}
