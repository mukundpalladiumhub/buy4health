<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('order_model');
    }

    public function index() {
        $post = $this->input->post();
        if (!empty($post)) {
            $this->order_model->search = isset($post['search']['value']) ? $post['search']['value'] : '';
            $this->order_model->start = isset($post['start']) ? $post['start'] : '';
            $this->order_model->length = isset($post['length']) ? $post['length'] : '';
            $colnum = array(
                0 => 'user_id',
                1 => 'product_id',
                2 => 'order_amount',
                3 => 'transaction_id',
                4 => 'status',
            );
            $this->order_model->column = isset($post['order'][0]['column']) ? $colnum[$post['order'][0]['column']] : '';
            $this->order_model->dire = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : '';
            $conn = FALSE;
            $abc = $this->order_model->show($conn);
            $conn = true;
            $result = $this->order_model->show($conn);
            $user = array();
            foreach ($result as $array) {
                if ($array['status'] == 1) {
                    $array['status'] = 'Active';
                } else {
                    $array['status'] = 'Inactive';
                }
                $id = $array['id'];
                $data['full_name'] = $array['full_name'];
                $data['title'] = $array['title'];
                $data['order_amount'] = $array['order_amount'];
                $data['transaction_id'] = $array['transaction_id'];
                $data['status'] = $array['status'];
                $data['action'] = '<a href="' . base_url() . 'order/view/' . $id . '" class="btn btn-xs btn-info"> View</a>';
                $user[] = $data;
            }
            $json = array(
                "draw" => $_POST['draw'],
                "data" => $user,
                "recordsFiltered" => intval($abc),
                "recordsTotal" => intval($abc),
            );
            echo json_encode($json);
            exit;
        }
        $abcd = $this->session->get_userdata('user_name');
        $this->load->view('layout/header.php');
        $this->load->view('layout/sidebar.php');
        $this->load->view('order_view.php');
        $this->load->view('layout/footer.php');
    }

    public function view($id) {
        $data = $this->order_model->fill($id);
        $abcd = $this->session->get_userdata('user_name');
        $this->load->view('layout/header.php');
        $this->load->view('layout/sidebar.php');
        $this->load->view('order_row_view.php', $data);
        $this->load->view('layout/footer.php');
    }

}

?>