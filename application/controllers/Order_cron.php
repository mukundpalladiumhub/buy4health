<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

//        $otherdb = $this->load->database('otherdb', TRUE);
//
//        $users = $otherdb->select('*')
////                ->limit(5)
//                ->get('order_details')
//                ->result_array();
//
//        echo '<pre>';
//        print_r($users);
//        die;


        $order_array = array();

        $order_array['user'] = array(
            'id' => 1,
            'fb_id' => '802981993087048',
            'password' => '123456',
            'email' => 'mahesh@velociters.com',
            'first_name' => 'Sandesh',
            'last_name' => 'Bhor',
            'address1' => 'Hadapsar',
            'zipcode' => '411028',
            'city' => 'Pune',
            'state' => 'MH',
            'mobile' => '9960921809',
            'phone' => '919952663355',
            'status' => 1
        );


        $order_array['orders'] = array(
            'order_id' => 1,
            'user_id' => 44,
            'order_number' => 'R4H1432893185',
            'order_delivery_charge' => 200,
            'total' => 1950,
            'convenience_charge' => 0,
            'shipping_rate' => '',
            'order_date' => '2015-05-29',
            'payment_method' => 'Cash On Delivery',
            'payment_status' => '',
            'order_status' => 0,
            'status' => 1,
        );
        $order_array['orders']['order_details'][] = array(
            'order_det_id' => 5,
            'order_id' => 5,
            'type' => 'r',
            'product_id' => 20,
            'size_id' => 40,
            'quantity' => 1,
            'price' => 400,
            'total_price' => 400,
            'rent_duration' => '1',
            'delivery_charge' => 0,
            'advance_amount' => 1200,
            'refund_amount' => 0,
            'damage_amount' => 0,
            'deliver_on' => date("Y-m-d", strtotime('2015-06-11')),
            'delivery_date' => date("Y-m-d", strtotime('2015-06-12')),
            'pickup_date' => date("Y-m-d", strtotime('2015-06-30')),
            'commison' => 0,
            'status' => 1
        );
        $order_array['orders']['order_details'][] = array(
            'order_det_id' => 5,
            'order_id' => 5,
            'type' => 'r',
            'product_id' => 20,
            'size_id' => 40,
            'quantity' => 1,
            'price' => 400,
            'total_price' => 400,
            'rent_duration' => '1',
            'delivery_charge' => 0,
            'advance_amount' => 1200,
            'refund_amount' => 0,
            'damage_amount' => 0,
            'deliver_on' => date("Y-m-d", strtotime('2015-06-11')),
            'delivery_date' => date("Y-m-d", strtotime('2015-06-12')),
            'pickup_date' => date("Y-m-d", strtotime('2015-06-30')),
            'commison' => 0,
            'status' => 1
        );
        $order_array['orders']['order_details'][] = array(
            'order_det_id' => 5,
            'order_id' => 5,
            'type' => 'r',
            'product_id' => 20,
            'size_id' => 40,
            'quantity' => 1,
            'price' => 400,
            'total_price' => 400,
            'rent_duration' => '1',
            'delivery_charge' => 0,
            'advance_amount' => 1200,
            'refund_amount' => 0,
            'damage_amount' => 0,
            'deliver_on' => date("Y-m-d", strtotime('2015-06-11')),
            'delivery_date' => date("Y-m-d", strtotime('2015-06-12')),
            'pickup_date' => date("Y-m-d", strtotime('2015-06-30')),
            'commison' => 0,
            'status' => 1
        );

        if (!empty($order_array)) {
            
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

                        if (!empty($order_details)) {

                            foreach ($order_details as $key => $order_detail) {

                                unset($order_detail['order_det_id']);
                                $order_detail['order_id'] = $order_id;

                                $this->db->insert('order_details', $order_detail);
                            }
                        }
                    }
                }
            }
        }
    }

}
