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
                if (isset($array['category_image']) && $array['category_image'] != '' && file_exists(FCPATH . 'assets/uploads/category/' .basename($array['category_image']))) {
                    $array['category_image'] = base_url() . 'assets/uploads/category/' . basename($array['category_image']);
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
            $product_details_all = array();
            $this->product_model->category_id = $category_id;
            $this->product_model->sort = isset($_GET['sort']) ? $_GET['sort'] : "";
            $this->product_model->type = isset($_GET['type']) ? $_GET['type'] : '';
            $this->product_model->min = isset($_GET['min']) ? $_GET['min'] : '';
            $this->product_model->max = isset($_GET['max']) ? $_GET['max'] : '';
            $product_details = $this->product_model->ViewList(true);

            foreach ($product_details as $key => $detail) {
                $products = array();
                $product_rent_details = array();
                $product_price_details = array();
                $product_images = $this->product_model->getProductImage($detail['id']);
                $product_image = array();
                if (empty($product_images)) {
                    $image['product_image'] = base_url() . 'assets/images/No-Image.png';
                    $product_image[] = $image['product_image'];
                }
                foreach ($product_images as $image) {
                    if (isset($image['product_image']) && $image['product_image'] != '' && file_exists(FCPATH . 'assets/uploads/product/' . $image['product_image'])) {
                        $image['product_image'] = base_url() . 'assets/uploads/product/' . $image['product_image'];
                    } else {
                        $image['product_image'] = base_url() . 'assets/images/No-Image.png';
                    }
                    $product_image[] = $image['product_image'];
                }

//                if ($detail['status'] == 1) {
//                    $detail['status'] = 'Active';
//                } else {
//                    $detail['status'] = 'Inactive';
//                }

                $product_details_all[$key] = $detail;
                $product_details_all[$key]['product_image'] = $product_image;

                if (isset($detail['product_type']) && $detail['product_type'] == 1) {

                    $product_rent_details = $this->product_model->getProductRent($detail['id']);

                    $product_rent_details['id'] = isset($product_rent_details['id']) ? $product_rent_details['id'] : "";
                    $product_rent_details['product_id'] = isset($product_rent_details['product_id']) ? $product_rent_details['product_id'] : "";
                    $product_rent_details['rent_duration'] = isset($product_rent_details['rent_duration']) ? $product_rent_details['rent_duration'] : "";
                    $product_rent_details['rent_amount'] = isset($product_rent_details['rent_amount']) ? $product_rent_details['rent_amount'] : "";
                    $product_rent_details['advance_amount'] = isset($product_rent_details['advance_amount']) ? $product_rent_details['advance_amount'] : "";
                    $product_rent_details['status'] = isset($product_rent_details['status']) ? $product_rent_details['status'] : "";

                    $product_details_all[$key]['product_rent_details'] = $product_rent_details;
                }
                if (isset($detail['product_type']) && $detail['product_type'] == 2) {

                    $product_price_details = $this->product_model->getProductPrice($detail['id']);

                    $product_price_details['id'] = isset($product_price_details['id']) ? $product_price_details['id'] : "";
                    $product_price_details['product_id'] = isset($product_price_details['product_id']) ? $product_price_details['product_id'] : "";
                    $product_price_details['size_type'] = isset($product_price_details['size_type']) ? $product_price_details['size_type'] : "";
                    $product_price_details['size_id'] = isset($product_price_details['size_id']) ? $product_price_details['size_id'] : "";
                    $product_price_details['quantity'] = isset($product_price_details['quantity']) ? $product_price_details['quantity'] : "";
                    $product_price_details['low_level'] = isset($product_price_details['low_level']) ? $product_price_details['low_level'] : "";
                    $product_price_details['service_tax'] = isset($product_price_details['service_tax']) ? $product_price_details['service_tax'] : "";
                    $product_price_details['mrp'] = isset($product_price_details['mrp']) ? $product_price_details['mrp'] : "";
                    $product_price_details['price'] = isset($product_price_details['price']) ? $product_price_details['price'] : "";
                    $product_price_details['status'] = isset($product_price_details['status']) ? $product_price_details['status'] : "";

                    $product_details_all[$key]['product_price_details'] = $product_price_details;
                }
                if (isset($detail['product_type']) && $detail['product_type'] == 3) {

                    $product_rent_details = $this->product_model->getProductRent($detail['id']);
                    $product_price_details = $this->product_model->getProductPrice($detail['id']);

                    $product_price_details['id'] = isset($product_price_details['id']) ? $product_price_details['id'] : "";
                    $product_price_details['product_id'] = isset($product_price_details['product_id']) ? $product_price_details['product_id'] : "";
                    $product_price_details['size_type'] = isset($product_price_details['size_type']) ? $product_price_details['size_type'] : "";
                    $product_price_details['size_id'] = isset($product_price_details['size_id']) ? $product_price_details['size_id'] : "";
                    $product_price_details['quantity'] = isset($product_price_details['quantity']) ? $product_price_details['quantity'] : "";
                    $product_price_details['low_level'] = isset($product_price_details['low_level']) ? $product_price_details['low_level'] : "";
                    $product_price_details['service_tax'] = isset($product_price_details['service_tax']) ? $product_price_details['service_tax'] : "";
                    $product_price_details['mrp'] = isset($product_price_details['mrp']) ? $product_price_details['mrp'] : "";
                    $product_price_details['price'] = isset($product_price_details['price']) ? $product_price_details['price'] : "";
                    $product_price_details['status'] = isset($product_price_details['status']) ? $product_price_details['status'] : "";

                    $product_rent_details['id'] = isset($product_rent_details['id']) ? $product_rent_details['id'] : "";
                    $product_rent_details['product_id'] = isset($product_rent_details['product_id']) ? $product_rent_details['product_id'] : "";
                    $product_rent_details['rent_duration'] = isset($product_rent_details['rent_duration']) ? $product_rent_details['rent_duration'] : "";
                    $product_rent_details['rent_amount'] = isset($product_rent_details['rent_amount']) ? $product_rent_details['rent_amount'] : "";
                    $product_rent_details['advance_amount'] = isset($product_rent_details['advance_amount']) ? $product_rent_details['advance_amount'] : "";
                    $product_rent_details['status'] = isset($product_rent_details['status']) ? $product_rent_details['status'] : "";

                    $product_details_all[$key]['product_price_details'] = $product_price_details;
                    $product_details_all[$key]['product_rent_details'] = $product_rent_details;
                }
            }
            $json = array("product" => $product_details_all);
            echo json_encode($json);
            exit;
        }
    }

    /* public function getFilterProduct($category_id = '') {
      $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
      $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
      $min = isset($_GET['min']) ? $_GET['min'] : '';
      $max = isset($_GET['max']) ? $_GET['max'] : '';
      $post = $this->input->post();
      $post = array("start" => 5);
      if (!empty($post)) {
      $product_details = $this->product_model->FilterList(true, $sort, $filter, $max, $min);
      foreach ($product_details as $key => $detail) {
      $product_price_details = array();
      $product_rent_details = array();
      $product_images = $this->product_model->getProductImage($detail['id']);
      $product_image = array();
      foreach ($product_images as $image) {
      if (isset($image['product_image']) && $image['product_image'] != '' && file_exists(FCPATH . 'assets/uploads/product/' . $image['product_image'])) {
      $image['product_image'] = base_url() . 'assets/uploads/product/' . $image['product_image'];
      } else {
      $image['product_image'] = base_url() . 'assets/images/No-Image.png';
      }
      $image_path = $image['product_image'];
      if (!empty($image_path)) {
      $product_image[] = $image_path;
      } else {
      $product_image = array();
      }
      }
      $product_price_details = $this->product_model->getProductPrice($detail['id']);
      if (!empty($product_price_details)) {
      $product_price_details[] = $product_price_details;
      } else {
      $product_price_details = array();
      }
      $product_rent_details = $this->product_model->getProductRent($detail['id']);
      if (!empty($product_rent_details)) {
      $product_rent_details[] = $product_rent_details;
      } else {
      $product_rent_details = array();
      }
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
      } */

    public function getProductDetails($id) {
        $post = $this->input->post();
        $post = array("start" => 5);
        if (!empty($post)) {
            $product_details = $this->product_model->getProductListbyid($id);
            $product_details_all = array();
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

//                if ($detail['status'] == 1) {
//                    $detail['status'] = 'Active';
//                } else {
//                    $detail['status'] = 'Inactive';
//                }
                $product_details_all = $detail;
                $product_details_all['product_image'] = $product_image;

                if (isset($detail['product_type']) && $detail['product_type'] == 1) {
                    $product_rent_details = $this->product_model->getProductRent($detail['id']);
                    $product_details_all['product_rent_details'] = $product_rent_details;
                } else if (isset($detail['product_type']) && $detail['product_type'] == 2) {

                    $product_price_details = $this->product_model->getProductPrice($detail['id']);
                    $product_details_all['product_price_details'] = $product_price_details;
                } else if (isset($detail['product_type']) && $detail['product_type'] == 3) {

                    $product_price_details = $this->product_model->getProductPrice($detail['id']);
                    $product_rent_details = $this->product_model->getProductRent($detail['id']);

                    $product_details_all['product_price_details'] = $product_price_details;
                    $product_details_all['product_rent_details'] = $product_rent_details;
                }
            }

            $json = array("product" => $product_details_all);
            echo json_encode($json);
            exit;
        }
    }

    public function orderPlace() {
        $order_array = array("start" => 5);
        $order_array = $this->input->post();
        $result_array = array();

        $this->load->helper('file');
        write_file("api_order.php", date("H:i:s").' ','a');
        write_file("api_order.php", print_r($order_array,true),'a');

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

                    $result_array['status'] = 1;
                    $result_array['msg'] = "User created successfully.";

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
                            $result_array['msg'] = "Order placed successfully for given user.";
                        } else {
                            $result_array['status'] = 0;
                            $result_array['msg'] = "Product not created. Please try again.";
                        }
                    }
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
