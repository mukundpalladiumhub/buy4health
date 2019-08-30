<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('category_model');
        $this->load->model('product_model');
    }

    public function getRSAPublicKey($orderId) {
        $url = "https://secure.ccavenue.com/transaction/getRSAKey";
        $accessCode = "AVMB87GH26BO73BMOB";
        $fields = array(
            'access_code' => $accessCode,
            'order_id' => $orderId
        );

        $postvars = '';
        $sep = '';
        foreach ($fields as $key => $value) {
            $postvars .= $sep . urlencode($key) . '=' . urlencode($value);
            $sep = '&';
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        $ipAddress = "160.153.71.161"; //Custom IP here
        //curl_setopt($ch, CURLOPT_HTTPHEADER, ["REMOTE_ADDR: $ipAddress", "HTTP_X_FORWARDED_FOR: $ipAddress"]);
        curl_setopt($ch, CURLOPT_INTERFACE, $ipAddress);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        //curl_setopt($ch, CURLOPT_CAINFO, 'replace this with your cacert.pem file path here');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);

        $result_array = array();
        $result_array['secret_key'] = $result;
        echo json_encode($result_array);
        exit;
    }

    public function getCategoriesList() {
        $post = $this->input->post();
        $post = array("start" => 5);
        if (!empty($post)) {
            $display_type = isset($_GET['display_type']) ? $_GET['display_type'] : '';
            $result = $this->category_model->getCategoryList($display_type);
            $categories = array();
            foreach ($result as $array) {
                if ($array['status'] == 1) {
                    $array['status'] = 'Active';
                } else {
                    $array['status'] = 'Inactive';
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
            $this->product_model->display_type = isset($_GET['display_type']) ? $_GET['display_type'] : '';
            $product_details = $this->product_model->ViewList(true);

            foreach ($product_details as $key => $detail) {
                $products = array();
                $product_rent_details = array();
                $product_price_details = array();
                $product_images = $this->product_model->getProductImage($detail['id']);
                $product_image = array();
                if (empty($product_images)) {
                    $image['product_image'] = 'https://www.buy4health.com/wp/wp-content/uploads/2019/07/woocommerce-placeholder.png';
                    $product_image[] = $image['product_image'];
                }
                foreach ($product_images as $image) {
                    if (isset($image['product_image']) && $image['product_image'] != '' && file_exists(FCPATH . 'assets/uploads/product/' . $image['product_image'])) {
                        $image['product_image'] = base_url() . 'assets/uploads/product/' . $image['product_image'];
                    } else {
                        $image['product_image'] = 'https://www.buy4health.com/wp/wp-content/uploads/2019/07/woocommerce-placeholder.png';
                    }
                    $product_image[] = $image['product_image'];
                }

                $product_details_all[$key] = $detail;
                $product_details_all[$key]['product_image'] = $product_image;

                if (isset($detail['product_type']) && $detail['product_type'] == 1) {

                    $product_rent_details = $this->product_model->getProductRent($detail['id']);

                    $product_details_all[$key]['product_rent_details'] = $product_rent_details;
                }
                if (isset($detail['product_type']) && $detail['product_type'] == 2) {

                    $product_price_details = $this->product_model->getProductPrice($detail['id']);

                    $product_details_all[$key]['product_price_details'] = $product_price_details;
                }
                if (isset($detail['product_type']) && $detail['product_type'] == 3) {

                    $product_rent_details = $this->product_model->getProductRent($detail['id']);
                    $product_price_details = $this->product_model->getProductPrice($detail['id']);

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
                        $image['product_image'] = 'https://www.buy4health.com/wp/wp-content/uploads/2019/07/woocommerce-placeholder.png';
                    }
                    $product_image[] = $image['product_image'];
                }

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
        $order_array = (array) json_decode(file_get_contents('php://input'), TRUE);

        $shipRocket_array = $order_array;

        if (!empty($order_array)) {
            if (isset($order_array['orders']['vandor_id']) && $order_array['orders']['vandor_id'] != "") {

                $vandor = $this->db->from('vandor_master')
                                ->select('*')
                                ->where('vandor_id', $order_array['orders']['vandor_id'])
                                ->get()->row_array();
                if (empty($vandor)) {
                    $result_array['status'] = 0;
                    $result_array['msg'] = "Vandor id not available.";
                    echo json_encode($result_array);
                    exit;
                }
            } else {
                $result_array['status'] = 0;
                $result_array['msg'] = "Please Provide Vandor Id.";
                echo json_encode($result_array);
                exit;
            }
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
                        $order_array['orders']['payment_status'] = PAYMENT_STATUS;
                        $order_array['orders']['order_status'] = ORDER_STATUS;

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

                            $this->shiprocket($shipRocket_array);
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

    public function cancel_url() {

        echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                   <meta charset="utf-8">
                   <meta http-equiv="X-UA-Compatible" content="IE=edge">
                   <meta name="viewport" content="width=device-width, initial-scale=1">
                   <!-- The above 3 meta tags must come first in the head; any other head content must come after these tags -->
                   <meta name="description" content="">
                   <meta name="author" content="">
                   <title>Please wait..</title>
                </head>

                <body>
                </body>
                <script type="text/javascript">
                   Payment.onFailure("");
                </script>
                </html>';
        exit;
    }

    public function return_url() {

        echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                   <meta charset="utf-8">
                   <meta http-equiv="X-UA-Compatible" content="IE=edge">
                   <meta name="viewport" content="width=device-width, initial-scale=1">
                   <!-- The above 3 meta tags must come first in the head; any other head content must come after these tags -->
                   <meta name="description" content="">
                   <meta name="author" content="">
                   <title>Please wait..</title>
                </head>

                <body>
                </body>
                <script type="text/javascript">
                   Payment.onSuccess("");
                </script>
                </html>';
        exit;
    }

    public function shiprocket($shipRocket_array) {

        if (!empty($shipRocket_array)) {

            include APPPATH . 'libraries/ShipRocket.php';

            $shiprocket = new ShipRocket;

            $ordermaster = (array) $shipRocket_array['orders'];
            $delivery = (array) $shipRocket_array['user'];
            $order_product = (array) $ordermaster['order_details'];

            $url = "external/orders/create/adhoc";

            $tmpProductDetais = array();
            $w = 0;
            $weight = 1;
            foreach ($order_product as $product_detais) {

                $product = $this->product_model->getProductName($product_detais['product_id']);

                $tmpProductDetais[$w] = array(
                    "name" => $product['product_name'],
                    "sku" => $product['product_code'],
                    "units" => $product_detais['quantity'],
                    "selling_price" => $product_detais['total_price'],
                    "discount" => "",
                    "tax" => "",
                    "hsn" => ""
                );
                $weight+= 0;
                $w++;
            }
            $itemArr = $tmpProductDetais;

            if ($ordermaster['payment_method'] == "Cash On Delivery") {
                $payMethod = "COD";
            } else {
                $payMethod = "Prepaid";
            }
            $orderData = array(
                "order_id" => $ordermaster['order_number'],
                "order_date" => $ordermaster['order_date'],
                "pickup_location" => "Primary",
                "channel_id" => "CUSTOM",
                "comment" => "Reseller: Rent4health",
                "billing_customer_name" => $delivery['first_name'],
                "billing_last_name" => $delivery['last_name'],
                "billing_address" => $delivery['address1'],
                "billing_address_2" => "",
                "billing_city" => $delivery['city'],
                "billing_pincode" => $delivery['zipcode'],
                "billing_state" => $delivery['state'],
                "billing_country" => "India",
                "billing_email" => $delivery['email'],
                "billing_phone" => $delivery['mobile'],
                "shipping_is_billing" => true,
                "shipping_customer_name" => $delivery['first_name'],
                "shipping_last_name" => $delivery['last_name'],
                "shipping_address" => $delivery['address1'],
                "shipping_address_2" => "",
                "shipping_city" => $delivery['city'],
                "shipping_pincode" => $delivery['zipcode'],
                "shipping_country" => "India",
                "shipping_state" => $delivery['state'],
                "shipping_email" => $delivery['email'],
                "shipping_phone" => $delivery['mobile'],
                "order_items" => $itemArr,
                "payment_method" => $payMethod,
                "shipping_charges" => $ordermaster['order_delivery_charge'],
                "giftwrap_charges" => "0",
                "transaction_charges" => "0",
                "total_discount" => "0",
                "sub_total" => $ordermaster['total'],
                "length" => "1",
                "breadth" => "1",
                "height" => "1",
                "weight" => $weight
            );

            $resposne = $shiprocket->sendCURL($url, $orderData);

            echo json_encode($resposne);
            exit;
        }
    }

    /* Start  Added By Sanket */

    public function registerVandor() {
        $vandor_array = $this->input->post();
        $vandor_array = (array) json_decode(file_get_contents('php://input'), TRUE);
        $resposeArr = array();
        if (isset($vandor_array['vandor']) && is_array($vandor_array['vandor'])) {
            $vandor_name = $vandor_array['vandor']['vandor_name'];
            $business_name = $vandor_array['vandor']['business_name'];
            $email_address = $vandor_array['vandor']['email_address'];
            $location = $vandor_array['vandor']['location'];
            $phone_number = $vandor_array['vandor']['phone_number'];
            $gstn = $vandor_array['vandor']['gstn'];

            if ($vandor_name == '') {
                $resposeArr = array('status' => 0, 'msg' => 'Please Provide The Vandor Name.');
                echo json_encode($resposeArr);
                exit;
            }

            if ($business_name == '') {
                $resposeArr = array('status' => 0, 'msg' => 'Please Provide The Business Name.');
                echo json_encode($resposeArr);
                exit;
            }

            if ($email_address == '') {
                $resposeArr = array('status' => 0, 'msg' => 'Please Provide The Email Address.');
                echo json_encode($resposeArr);
                exit;
            }

            if ($location == '') {
                $resposeArr = array('status' => 0, 'msg' => 'Please Provide The Vandor Location.');
                echo json_encode($resposeArr);
                exit;
            }

            if ($phone_number == '') {
                $resposeArr = array('status' => 0, 'msg' => 'Please Provide The Phone Number.');
                echo json_encode($resposeArr);
                exit;
            }


            if ($vandor_name != '' && $business_name != '' && $email_address != '' && $location != '' && $phone_number != '') {
                $vanArr['vandor_code'] = "VNDR" . time();
                $vanArr['vandor_name'] = $vandor_name;
                $vanArr['business_name'] = $business_name;
                $vanArr['phone_numer'] = $phone_number;
                $vanArr['email_address'] = $email_address;
                $vanArr['GSTN'] = $gstn;
                $vanArr['location'] = $location;
                $vanArr['created_date'] = date('Y-m-d H:i:s');

                $this->db->insert('vandor_master', $vanArr);
                $vandor_id = $this->db->insert_id();

                if ($vandor_id > 0) {
                    $vandorData = $this->db->select('*')
                            ->from('vandor_master')
                            ->where('vandor_id', $vandor_id)
                            ->get()
                            ->row_array();
                    $resposeArr = array('status' => 1, 'msg' => 'Vandor Created Successfully.', 'data' => $vandorData);
                    echo json_encode($resposeArr);
                    exit;
                } else {
                    $resposeArr = array('status' => 0, 'msg' => 'Vandor Can Not Be Created. Please Try Again!!');
                    echo json_encode($resposeArr);
                    exit;
                }
            } else {
                $resposeArr = array('status' => 0, 'msg' => 'Invalid Data Format. Please Try Again!!');
                echo json_encode($resposeArr);
                exit;
            }
        } else {
            $resposeArr = array('status' => 0, 'msg' => 'Invalid Data Format. Please Try Again.');
            echo json_encode($resposeArr);
            exit;
        }
    }

    /* End  Added By Sanket */
}
