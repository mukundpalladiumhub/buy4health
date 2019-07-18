<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->session->userdata('user_id')) {
            return redirect('user');
        } else {
            $this->load->view('login.php');
        }
    }

    public function login_action() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_name', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $result = array();
        if ($this->form_validation->run() == FALSE) {
            $result['status'] = 0;
            $result['msg'] = validation_errors();
        } else {
            $user_name = $this->input->post('user_name');
            $password = $this->input->post('password');
            $decode_password = md5($password);
            $id = $this->login_model->login($user_name, $decode_password);
            $userbyid = $this->login_model->userbyid($id);
            if ($id != FALSE) {
                $this->load->library('session');
                $this->session->set_userdata('user_id', $id);
                $this->session->set_userdata('user_name', $userbyid['full_name']);
                $this->session->set_userdata('photo', $userbyid['profile_image']);

                $result['status'] = 1;
                $result['msg'] = 'Login Successfully';
                $result['redirect'] = base_url() . "/user";
            } else {
                $user = $this->login_model->alltable();
                foreach ($user as $data) {
                    if ($data['user_name'] != $user_name) {
                        $b = 'Invalid Username or Password';
                    } elseif ($data['status'] == 0) {
                        $b = 'E-mail is not Verified';
                    }
                }
                $result['status'] = 0;
                $result['msg'] = $b;
            }
        }
        echo json_encode($result);
        exit;
    }

}

?>