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

    public function getProductList($category_id = '') {
        $post = $this->input->post();
        $post = array("start" => 5);
        if (!empty($post)) {
            $product_details = $this->product_model->ViewList(true, $category_id);
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
                $product_details_all[$key] = $detail;
                $product_details_all[$key]['product_image'] = $product_image;
                $product_details_all[$key]['product_price_details'] = $product_price_details;
                $product_details_all[$key]['product_rent_details'] = $product_rent_details;
            }
            $json = array("product" => $product_details_all);
            echo json_encode($json);
            exit;
        }
    }

    public function getProductDetails($id) {
        $post = $this->input->post();
        $post = array("start" => 5);
        if (!empty($post)) {
            $product_details = $this->product_model->getProductListbyid($id);
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
                $product_details_all = $detail;
                $product_details_all['product_image'] = $product_image;
                $product_details_all['product_price_details'] = $product_price_details;
                $product_details_all['product_rent_details'] = $product_rent_details;
            }
            $json = array("product" => $product_details_all);
            echo json_encode($json);
            exit;
        }
    }

    public function orderPlace() {

        $order_array = $this->input->post();

        $result_array = array();
        if (!empty($order_array)) {

            $result_array = array();

            if (!empty($order_array['user'])) {

                $email = isset($order_array['user']['email']) ? $order_array['user']['email'] : "";
                $user = $this->db->select('*')
                        ->from('users')
                        ->where('email', $email)
                        ->get()
                        ->row_array();

                unset($order_array['user']['id']);

                $user_data = $order_array['user'];
                if (!empty($user)) {
                    $user_id = $user['id'];
                    $this->db->where('id', $user_id);
                    $this->db->update('users', $user_data);
                } else {
                    $user_data['role_id'] = USER_ROLE;
                    $this->db->insert('users', $user_data);
                    $user_id = $this->db->insert_id();
                }

                if (isset($user_id) && $user_id != "") {

                    if (!empty($order_array['orders'])) {

                        $order_details = $order_array['orders']['order_details'];

                        unset($order_array['orders']['order_id']);
                        unset($order_array['orders']['order_details']);
                        $order_array['orders']['user_id'] = $user_id;

                        $this->db->insert('orders', $order_array['orders']);
                        $order_id = $this->db->insert_id();

                        if (isset($order_id) && $order_id != "") {

                            if (!empty($order_details)) {

                                foreach ($order_details as $key => $order_detail) {

                                    unset($order_detail['order_det_id']);
                                    $order_detail['order_id'] = $order_id;

                                    $this->db->insert('order_details', $order_detail);
                                }
                            }
                            $result_array['status'] = 1;
                            $result_array['msg'] = "Product created successfully.";
                        } else {
                            $result_array['status'] = 0;
                            $result_array['msg'] = "Product not created. Please try again.";
                        }
                    }
                    $result_array['status'] = 1;
                    $result_array['msg'] = "User created successfully.";
                } else {
                    $result_array['status'] = 0;
                    $result_array['msg'] = "User not created. Please try again.";
                }
            }
        }

        echo json_encode($result_array);
        exit;
    }

}
