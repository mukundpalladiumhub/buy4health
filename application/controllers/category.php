<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('category_model');
    }

    public function index() {
        $post = $this->input->post();
        if (!empty($post)) {
            $this->category_model->search = isset($post['search']['value']) ? $post['search']['value'] : '';
            $this->category_model->start = isset($post['start']) ? $post['start'] : '';
            $this->category_model->length = isset($post['length']) ? $post['length'] : '';
            $colnum = array(
                0 => 'name',
                1 => 'description',
                2 => 'status',
            );
            $this->category_model->column = isset($post['order'][0]['column']) ? $colnum[$post['order'][0]['column']] : '';
            $this->category_model->dire = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : '';
            $conn = FALSE;
            $abc = $this->category_model->show($conn);
            $conn = true;
            $result = $this->category_model->show($conn);
            $user = array();
            foreach ($result as $array) {
                if ($array['status'] == 1) {
                    $array['status'] = 'Active';
                } else {
                    $array['status'] = 'Inactive';
                }
                $id = $array['id'];
                $data['name'] = $array['name'];
                $data['description'] = $array['description'];
                $data['status'] = $array['status'];
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
        $this->load->view('category_view.php');
        $this->load->view('layout/footer.php');
    }
}
?>