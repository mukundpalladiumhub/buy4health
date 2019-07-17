<?php

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
    }

    public function index() {
        $post = $this->input->post();
        if (!empty($post)) {
            $this->product_model->search = isset($post['search']['value']) ? $post['search']['value'] : '';
            $this->product_model->start = isset($post['start']) ? $post['start'] : '';
            $this->product_model->length = isset($post['length']) ? $post['length'] : '';
            $colnum = array(
                0 => 'title',
                1 => 'description',
                2 => 'price',
                3 => 'status',
            );
            $this->product_model->column = isset($post['order'][0]['column']) ? $colnum[$post['order'][0]['column']] : '';
            $this->product_model->dire = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : '';
            $conn = FALSE;
            $abc = $this->product_model->show($conn);
            $conn = true;
            $result = $this->product_model->show($conn);
            $user = array();
            foreach ($result as $array) {
                if ($array['status'] == 1) {
                    $array['status'] = 'Active';
                } else {
                    $array['status'] = 'Inactive';
                }
                $id = $array['id'];
                $data['title'] = $array['title'];
                $data['description'] = $array['description'];
                $data['price'] = $array['price'];
                $data['status'] = $array['status'];
                $data['action'] = '<a href="' . base_url() . 'product/view/' . $id . '" class="btn btn-xs btn-info"> View</a>';
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
        $this->load->view('product_view.php');
        $this->load->view('layout/footer.php');
    }
    
    public function view($id) {
        $data = $this->product_model->fill($id);
        $abcd = $this->session->get_userdata('user_name');
        $this->load->view('layout/header.php');
        $this->load->view('layout/sidebar.php');
        $this->load->view('product_row_view.php', $data);
        $this->load->view('layout/footer.php');
    }


}

?>