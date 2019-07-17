<?php

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index() {
        $post = $this->input->post();
        if (!empty($post)) {
            $this->user_model->search = isset($post['search']['value']) ? $post['search']['value'] : '';
            $this->user_model->start = isset($post['start']) ? $post['start'] : '';
            $this->user_model->length = isset($post['length']) ? $post['length'] : '';
            $colnum = array(
                0 => 'full_name',
                1 => 'user_name',
                2 => 'password',
            );
            $this->user_model->column = isset($post['order'][0]['column']) ? $colnum[$post['order'][0]['column']] : '';
            $this->user_model->dire = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : '';
            $conn = FALSE;
            $abc = $this->user_model->show($conn);
            $conn = true;
            $result = $this->user_model->show($conn);
            $user = array();
            foreach ($result as $array) {
                $id = $array['id'];
                $data['name'] = $array['full_name'];
                $data['email'] = $array['user_name'];
                $data['password'] = $array['password'];
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
        $this->load->view('user_view.php');
        $this->load->view('layout/footer.php');
    }

}

?>