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
            $id = $this->Login_model->login($user_name, $decode_password);
            $userbyid = $this->Login_model->userbyid($id);
            if ($id != FALSE) {
                $this->load->library('session');
                $this->session->set_userdata('user_id', $id);
                $this->session->set_userdata('user_name', $userbyid['full_name']);
                $this->session->set_userdata('photo', $userbyid['profile_image']);

                $result['status'] = 1;
                $result['msg'] = 'Login Successfully';
                $result['redirect'] = base_url() . "/user";
            } else {
                $user = $this->Login_model->alltable();
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

    public function forgot_password() {
        $this->load->view('forgot_view.php');
    }

    public function check_email() {
        $user_name = $this->input->post('user_name');
        $data = $this->Login_model->check_id($user_name);
        $a = 1;
        if ($data != '') {
            $set = '12345687890abcdefghijklmnopqrstuvwxyz';
            $code = substr(str_shuffle($set), 0, 12);
            $this->Login_model->update_code($code, $user_name);
            $this->sendMail($user_name, $code, $a, $data);
            $result['status'] = 1;
            $result['msg'] = 'Mail verified';
        } else {
            $result['status'] = 0;
            $result['msg'] = "Invalid E-mail id";
        }
        echo json_encode($result);
        exit;
    }

    function sendMail($user_name, $code, $a, $data) {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'sunny.patel477@gmail.com',
            'smtp_pass' => 'S1u7n3ny_',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        $data['code'] = $code;
        $data['user_name'] = $user_name;
        $data['image'] = base_url() . RENT4HEALTH;
        if ($a == 1) {
            $subject = 'Change your password';
            $message = $this->load->view('templates/password_mail.php', $data, TRUE);
        } else if ($a == 0) {
            $subject = 'Signup Verification Email';
            $message = $this->load->view('templates/check_mail.php', $data, TRUE);
        }
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('niravpatel26oct@gmail.com');
        $this->email->to($user_name);
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send()) {
            $this->session->set_flashdata('message', 'Activation code sent to email');
        } else {
            $this->session->set_flashdata('message', $this->email->print_debugger());
        }
    }

    public function change_pass() {
        $code = $this->uri->segment(3);
        $user = array();
        $user = $this->Login_model->userbycode($code);
        if ($user['code'] == $code) {
            $this->load->view('change_password.php', $user);
        } else {
            echo "Code dose not match";
            exit;
        }
    }

    public function change() {
        $id = $this->input->post('id');
        $password = $this->input->post('password');
        $decode_password = md5($password);
        $this->Login_model->update_password($decode_password, $id);
        return;
    }

}

?>