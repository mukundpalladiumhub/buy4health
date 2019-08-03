<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
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
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $result = array();
        if ($this->form_validation->run() == FALSE) {
            $result['status'] = 0;
            $result['msg'] = validation_errors();
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $decode_password = md5($password);
            $user = $this->Login_model->login($email, $decode_password);
            if (!empty($user)) {
                $this->load->library('session');
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('email', $user['email']);
                $this->session->set_userdata('name', $user['first_name'] . ' ' . $user['last_name']);
                $result['status'] = 1;
                $result['msg'] = 'Login Successfully';
            } else {
                $result['status'] = 0;
                $result['msg'] = 'Invalid Username or Password';
            }
        }
        echo json_encode($result);
        exit;
    }

    public function forgot_password() {
        $this->load->view('forgot_view.php');
    }

    public function check_email() {
        $email = $this->input->post('email');
        $data = $this->Login_model->check_id($email);
        if (!empty($data)) {
            $code = base64_encode($data['id']);
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => SMTP_HOST,
                'smtp_port' => 465,
                'smtp_user' => SMTP_USER,
                'smtp_pass' => SMTP_PASSWORD,
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
                'wordwrap' => TRUE
            );
            $data['email'] = $email;
            $data['image'] = base_url() . EMAIL_LOGO;
            $data['link'] = base_url() . 'login/change_pass/' . $code;
            $subject = 'Change your password';
            $message = $this->load->view('templates/password_mail.php', $data, TRUE);
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from(SMTP_USER);
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($message);
            if ($this->email->send()) {
                $result['status'] = 1;
                $result['msg'] = 'Email Sent';
            } else {
                $result['status'] = 0;
                $result['msg'] = 'Email Not Sent';
            }
        } else {
            $result['status'] = 0;
            $result['msg'] = "Invalid Email";
        }
        echo json_encode($result);
        exit;
    }

    public function change_pass($id) {
        $user_id = base64_decode($id);
        $user = array();
        $user = $this->Login_model->userbycode($user_id);
        if (!empty($user)) {
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