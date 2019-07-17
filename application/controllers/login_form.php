<?php

class Login_form extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        if ($this->session->userdata('user_id')) {
            // return redirect('popup/form');
        } else {
            
        }
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function form() {
        if ($this->session->userdata('user_id')) {
            return redirect('new_form/form');
        } else {
            $this->load->view('new/login.php');
        }
    }

    public function signup() {
        $this->load->view('new/register');
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
                $result['redirect'] = base_url() . "index.php/popup/form";
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

    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fname', 'Full name', 'required|trim');
        $this->form_validation->set_rules('mnum', 'Mobile number', 'required|trim');
        $this->form_validation->set_rules('user_name', 'Username', 'required|trim|is_unique[user_details.user_name]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $result['status'] = 0;
            $result['msg'] = validation_errors();
        } else {
            $id = $this->input->post('id');
            $hdn_img = $this->input->post('img_id');
            $user_name = $this->input->post('user_name');
            $a = 0;
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                $img = $_FILES['image']['name'];
                $config['upload_path'] = FCPATH . 'assets\images';
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $data = array('upload_data' => $this->upload->data());
                }
            }
            $password = $this->input->post('password');
            $encrypt_password = md5($password);
            $set = '12345687890abcdefghijklmnopqrstuvwxyz';
            $code = substr(str_shuffle($set), 0, 12);
            $_POST['image'] = isset($img) ? $img : $hdn_img;
            $totaldata = array(
                'full_name' => $this->input->post('fname'),
                'mobile_no' => $this->input->post('mnum'),
                'gender' => $this->input->post('gender'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'user_name' => $this->input->post('user_name'),
                'password' => $encrypt_password,
                'profile_image' => $this->input->post('image'),
                'code' => $code,
            );
            $this->login_model->signup($totaldata);
            $this->sendMail($user_name, $code, $a);
            $result['status'] = 1;
            $result['msg'] = 'Data Inserted';
        }
        echo json_encode($result);
        exit;
    }

    public function check() {
        $code = $this->uri->segment(3);
        $user = $this->login_model->userbycode($code);
        if ($user['code'] == $code) {
            $data['active'] = '1';
            $query = $this->login_model->verify($code);
        } else {
            echo "Code dose not match";
            exit;
        }
        redirect(base_url() . 'index.php/login_form/form');
    }

    public function forgot() {
        $this->load->view('new/forgot_view.php');
    }

    public function change_pass() {
        $code = $this->uri->segment(3);
        $user = $this->login_model->userbycode($code);
        if ($user['code'] == $code) {
            $this->load->view('new/change_password.php', $user);
        } else {
            echo "Code dose not match";
            exit;
        }
    }

    public function change() {
        $id = $this->input->post('id');
        $pass = $this->input->post('password');
        $this->login_model->update_pass($pass, $id);
        return;
    }

    public function check_id() {
        $user_name = $this->input->post('user_name');
        $data = $this->login_model->check_id($user_name);
        $a = 1;
        if ($data != '') {
            $set = '12345687890abcdefghijklmnopqrstuvwxyz';
            $code = substr(str_shuffle($set), 0, 12);
            $this->login_model->update_code($code, $user_name);
            $this->sendMail($user_name, $code, $a);
            $result['status'] = 1;
            $result['msg'] = 'Mail verified';
        } else {
            $result['status'] = 0;
            $result['msg'] = "Invalid E-mail id";
        }
        echo json_encode($result);
        exit;
    }

    function sendMail($user_name, $code, $a) {
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
        if ($a == 1) {
            $subject = 'Change your password';
            $message = $this->load->view('new/password_mail.php', $data, TRUE);
        } else if ($a == 0) {
            $subject = 'Signup Verification Email';
            $message = $this->load->view('new/check_mail.php', $data, TRUE);
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

}

?>