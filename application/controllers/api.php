<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('category_model');
        $this->load->model('product_model');
    }

    public function getCategoriesList() {
        $post = $this->input->post();
        $post = array("start" => 5);
        if (!empty($post)) {
            $result = $this->category_model->getCategoryList();
            $categories = array();
            foreach ($result as $array) {
                if ($array['status'] == 1) {
                    $array['status'] = 'Active';
                } else {
                    $array['status'] = 'Inactive';
                }
                if (isset($array['category_image']) && $array['category_image'] != '' && file_exists(FCPATH . 'assets/uploads/category/' . $array['category_image'])) {
                    $array['category_image'] = base_url() . 'assets/uploads/category/' . $array['category_image'];
                } else {
                    $array['category_image'] = base_url() . 'assets/images/No-Image.png';
                }

                $categories[] = $array;
            }
            $json = array("categories" => $categories);
            echo json_encode($json);
            exit;
        }
    }

    public function getProductList() {
        $post = $this->input->post();
        $post = array("start" => 5);
        if (!empty($post)) {
            $product_details = $this->product_model->getProductList();
            foreach ($product_details as $key => $detail) {
                $products = array();
                $product_rent_details = array();
                $product_price_details = array();
                $product_images = $this->product_model->getProductImage($detail['id']);
                $product_image = array();
                foreach ($product_images as $image) {
                    if (isset($image['product_image']) && $image['product_image'] != '' && file_exists(FCPATH . 'assets/uploads/product/' . $image['product_image'])) {
                        $image['product_image'] = base_url() . 'assets/uploads/product/' . $image['product_image'];
                    } else {
                        $image['product_image'] = base_url() . 'assets/images/No-Image.png';
                    }
                    $product_image[] = $image['product_image'];
                }
                $product_price_details[] = $this->product_model->getProductPrice($detail['id']);
                $product_rent_details[] = $this->product_model->getProductRent($detail['id']);

                if ($detail['status'] == 1) {
                    $detail['status'] = 'Active';
                } else {
                    $detail['status'] = 'Inactive';
                }
                $product_details_all[] = $detail;
                $product_details_all[$key]['product_image'] = $product_image;
                $product_details_all[$key]['product_price_details'] = $product_price_details;
                $product_details_all[$key]['product_rent_details'] = $product_rent_details;
            }
            $json = array("product" => $product_details_all);
            echo json_encode($json);
            exit;
        }
    }

}
