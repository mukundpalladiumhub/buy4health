<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('order_model');
    }

    public function index() {

        if ($this->session->userdata('user_id')) {
            $abcd = $this->session->get_userdata('user_name');
            $data['title'] = 'Order';
            $this->load->view('layout/header.php', $data);
            $this->load->view('layout/sidebar.php');
            $this->load->view('order_view.php');
            $this->load->view('layout/footer.php');
        } else {
            return redirect('login');
        }

        $post = $this->input->post();

        if (!empty($post)) {

            $colnum = array(
                0 => 'u.first_name',
                1 => 'o.order_number',
                2 => 'o.order_delivery_charge',
                3 => 'o.total',
                4 => 'o.convenience_charge',
                5 => 'o.shipping_rate',
                6 => 'o.order_date',
                7 => 'o.payment_method',
                8 => 'o.payment_status',
                9 => 'o.order_status',
                10 => 'o.status',
            );

            $this->order_model->search = isset($post['search']['value']) ? $post['search']['value'] : '';
            $this->order_model->start = isset($post['start']) ? $post['start'] : '';
            $this->order_model->length = isset($post['length']) ? $post['length'] : '';
            $this->order_model->column = isset($post['order'][0]['column']) ? $colnum[$post['order'][0]['column']] : '';
            $this->order_model->dire = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : '';

            $conn = FALSE;
            $count = $this->order_model->OrderList($conn);
            $conn = true;
            $order_details = $this->order_model->OrderList($conn);

            $order_data = array();

            foreach ($order_details as $array) {

                $id = $array['order_id'];
                $data['user_name'] = $array['first_name'] . " " . $array['last_name'];
                $data['order_number'] = $array['order_number'];
                $data['order_delivery_charge'] = $array['order_delivery_charge'];
                $data['total'] = $array['total'];
                $data['convenience_charge'] = $array['convenience_charge'];
                $data['shipping_rate'] = $array['shipping_rate'];
                $data['order_date'] = $array['order_date'];
                $data['payment_method'] = $array['payment_method'];
                $data['payment_status'] = $array['payment_status'];
                $data['order_status'] = $array['order_status'];
                $data['status'] = $array['status'];
                $data['action'] = '<a href="' . base_url() . 'order/order_detail_view/' . $id . '" class="btn btn-xs btn-info"> View</a>';
                $order_data[] = $data;
            }
            $json = array(
                "draw" => $_POST['draw'],
                "data" => $order_data,
                "recordsFiltered" => intval($count),
                "recordsTotal" => intval($count),
            );
            echo json_encode($json);
            exit;
        }
    }

    public function order_detail_view($id) {

        $data['order_id'] = $id;
        $data['title'] = 'Order Detail';
        $this->load->view('layout/header.php', $data);
        $this->load->view('layout/sidebar.php');
        $this->load->view('order_detail_view.php', $data);
        $this->load->view('layout/footer.php');
    }

    public function order_detail($id) {

        $post = $this->input->post();

        if (!empty($post)) {

            $colnum = array(
                0 => 'o.order_number',
                1 => 'od.type',
                2 => 'p.product_name',
                3 => 's.size',
                4 => 'od.quantity',
                5 => 'od.price',
                6 => 'od.total_price',
                7 => 'od.rent_duration',
                8 => 'od.delivery_charge',
                9 => 'od.advance_amount',
                10 => 'od.refund_amount',
                11 => 'od.damage_amount',
                12 => 'od.deliver_on',
                13 => 'od.delivery_date',
                14 => 'od.pickup_date',
                15 => 'od.commison',
                16 => 'od.status',
            );

            $this->order_model->search = isset($post['search']['value']) ? $post['search']['value'] : '';
            $this->order_model->start = isset($post['start']) ? $post['start'] : '';
            $this->order_model->length = isset($post['length']) ? $post['length'] : '';
            $this->order_model->column = isset($post['order'][0]['column']) ? $colnum[$post['order'][0]['column']] : '';
            $this->order_model->dire = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : '';

            $conn = FALSE;
            $count = $this->order_model->OrderDetailList($conn, $id);
            $conn = true;
            $order_details_list = $this->order_model->OrderDetailList($conn, $id);
            
            $order_detail_data = array();

            foreach ($order_details_list as $array) {

                $id = $array['order_det_id'];
                $data['order_number'] = $array['order_number'];
                $data['type'] = $array['type'];
                $data['product_name'] = $array['product_name'];
                $data['size'] = $array['size'];
                $data['quantity'] = $array['quantity'];
                $data['price'] = $array['price'];
                $data['total_price'] = $array['total_price'];
                $data['rent_duration'] = $array['rent_duration'];
                $data['delivery_charge'] = $array['delivery_charge'];
                $data['advance_amount'] = $array['advance_amount'];
                $data['refund_amount'] = $array['refund_amount'];
                $data['damage_amount'] = $array['damage_amount'];
                $data['deliver_on'] = $array['deliver_on'];
                $data['delivery_date'] = $array['delivery_date'];
                $data['pickup_date'] = $array['pickup_date'];
                $data['commison'] = $array['commison'];
                $data['status'] = $array['status'];
                $order_detail_data[] = $data;
            }
            $json = array(
                "draw" => $_POST['draw'],
                "data" => $order_detail_data,
                "recordsFiltered" => intval($count),
                "recordsTotal" => intval($count),
            );
            echo json_encode($json);
            exit;
        }
    }

    public function view($id) {
        $data = $this->order_model->view($id);
        $session_username = $this->session->get_userdata('user_name');
        $this->load->view('layout/header.php', $session_username);
        $this->load->view('layout/sidebar.php', $session_username);
        $this->load->view('order_row_view.php', $data);
        $this->load->view('layout/footer.php');
    }

}

?>