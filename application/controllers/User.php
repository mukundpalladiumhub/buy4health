<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index() {
        if ($this->session->userdata('user_id')) {
            $abcd = $this->session->get_userdata('user_name');
            $this->load->view('layout/header.php');
            $this->load->view('layout/sidebar.php');
            $this->load->view('user_view.php');
            $this->load->view('layout/footer.php');
        } else {
            return redirect('login');
        }
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
            $count = $this->user_model->UserList($conn);
            $conn = true;
            $result = $this->user_model->UserList($conn);
            $user_data = array();
            foreach ($result as $array) {
                $id = $array['id'];
                $data['name'] = $array['full_name'];
                $data['email'] = $array['user_name'];
                $data['password'] = $array['password'];
                $user_data[] = $data;
            }
            $json = array(
                "draw" => $_POST['draw'],
                "data" => $user_data,
                "recordsFiltered" => intval($count),
                "recordsTotal" => intval($count),
            );
            echo json_encode($json);
            exit;
        }
    }

    public function change_password() {
        $abcd = $this->session->get_userdata('user_name');
        $this->load->view('layout/header.php', $abcd);
        $this->load->view('layout/sidebar.php', $abcd);
        $this->load->view('change_view.php');
        $this->load->view('layout/footer.php');
    }

    public function password_id() {
        $old_pass = $this->input->post('old_pass');
        $new_pass = $this->input->post('password');
        $id = $this->session->userdata('user_id');
        $user = $this->new_model->change_pass($old_pass, $new_pass, $id);
        if ($user != $old_pass) {
            $result['status'] = 1;
            $result['msg'] = 'Password change successfully';
        } else {
            $result['status'] = 0;
            $result['msg'] = 'Old password dose not match';
        }
        echo json_encode($result);
        exit;
    }
    
    public function logout() {
        $this->session->unset_userdata('user_id');
        redirect(base_url() . 'login');
    }

}

?>