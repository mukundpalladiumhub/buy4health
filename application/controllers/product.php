<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
    }

    public function index() {
        if ($this->session->userdata('user_id')) {
            $abcd = $this->session->get_userdata('user_name');
            $this->load->view('layout/header.php');
            $this->load->view('layout/sidebar.php');
            $this->load->view('product_view.php');
            $this->load->view('layout/footer.php');
        } else {
            return redirect('login');
        }
        $post = $this->input->post();
        if (!empty($post)) {
            $this->product_model->search = isset($post['search']['value']) ? $post['search']['value'] : '';
            $this->product_model->start = isset($post['start']) ? $post['start'] : '';
            $this->product_model->length = isset($post['length']) ? $post['length'] : '';
            $colnum = array(
                0 => 'product_type',
                1 => 'product_code',
                2 => 'product_name',
                3 => 'category',
                4 => 'sub_category',
                5 => 'status',
            );
            $this->product_model->column = isset($post['order'][0]['column']) ? $colnum[$post['order'][0]['column']] : '';
            $this->product_model->dire = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : '';
            $conn = FALSE;
            $user = $this->product_model->ViewList($conn);
            $conn = true;
            $result = $this->product_model->ViewList($conn);
            $product_data = array();
            foreach ($result as $array) {
                if ($array['status'] == 1) {
                    $array['status'] = 'Active';
                } else {
                    $array['status'] = 'Inactive';
                }
                $id = $array['id'];
                $data['product_type'] = $array['product_type'];
                $data['product_code'] = $array['product_code'];
                $data['product_name'] = $array['product_name'];
                $data['category'] = $array['category_name'];
                $data['sub_category'] = $array['sub_category'];
                $data['status'] = $array['status'];
                $data['action'] = '<a href="' . base_url() . 'product/view/' . $id . '" class="btn btn-xs btn-info"> View</a>';
                $product_data[] = $data;
            }
            $json = array(
                "draw" => $_POST['draw'],
                "data" => $product_data,
                "recordsFiltered" => intval($user),
                "recordsTotal" => intval($user),
            );
            echo json_encode($json);
            exit;
        }
    }

    public function view($id) {
        $data = $this->product_model->view($id);
        $session_username = $this->session->get_userdata('user_name');
        $this->load->view('layout/header.php', $session_username);
        $this->load->view('layout/sidebar.php', $session_username);
        $this->load->view('product_row_view.php', $data);
        $this->load->view('layout/footer.php');
    }

}

?>