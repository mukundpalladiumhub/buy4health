<?php

class Popup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('new_model');
        if ($this->session->userdata('user_id')) {
            
        } else {
            return redirect('login_form/form');
        }
    }

    public function form() {
        $abcd = $this->session->get_userdata('user_name');
        $this->load->view('new/header.php', $abcd);
        $this->load->view('new/sidebar.php', $abcd);
        $this->load->view('new/popup_view.php');
        $this->load->view('new/footer.php');
    }

    public function save() {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $hdn_img = isset($_POST['img_id']) ? $_POST['img_id'] : '';

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
        $_POST['image'] = isset($img) ? $img : $hdn_img;

        $password = $this->input->post('password');
        $encrypt_password = md5($password);
        $set = '12345687890abcdefghijklmnopqrstuvwxyz';
        $code = substr(str_shuffle($set), 0, 12);
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
        if (isset($_POST['id']) && $_POST['id'] != '') {
            $result = $this->new_model->update($totaldata, $id);
            echo json_encode($result);
            exit;
        } else {
            $result = $this->new_model->add($totaldata);
            echo json_encode($result);
            exit;
        }
    }

    public function showtable() {
        $post = array();
        $post = $this->input->post();
        $this->new_model->search = isset($post['search']['value']) ? $post['search']['value'] : '';
        $this->new_model->start = isset($post['start']) ? $post['start'] : '';
        $this->new_model->length = isset($post['length']) ? $post['length'] : '';
        $colnum = array(
            0 => 'profile_image',
            1 => 'full_name',
            2 => 'mobile_no',
            3 => 'gender',
            4 => 'city',
            5 => 'state',
            6 => 'user_name',
            7 => 'password',
        );
        $this->new_model->column = isset($post['order'][0]['column']) ? $colnum[$post['order'][0]['column']] : '';
        $this->new_model->dire = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : '';
        $conn = FALSE;
        $abc = $this->new_model->show($conn);
        $conn = true;
        $result = $this->new_model->show($conn);
        $user = array();
        foreach ($result as $array) {
            if ($array['gender'] == 0) {
                $array['gender'] = 'Female';
            } elseif ($array['gender'] == 1) {
                $array['gender'] = 'Male';
            }
            $data['profile_image'] = "<img src='" . base_url() . "assets/images/" . $array['profile_image'] . "' style='height: 30px;width: 30px;' >";
            $data['full_name'] = $array['full_name'];
            $data['mobile_no'] = $array['mobile_no'];
            $data['gender'] = $array['gender'];
            $data['city'] = $array['city'];
            $data['state'] = $array['state'];
            $data['user_name'] = $array['user_name'];
            $data['password'] = $array['password'];
            $data['action'] = "<input type='button' class='edit' data-id='" . $array['id'] . "' data-target='#div_form' data-toggle='modal' value='Edit'>"
                    . "<input type='button' class='delete' data-id='" . $array['id'] . "' value='Delete'>";
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

    public function edit() {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $result = $this->new_model->fill($id);
        echo json_encode($result);
        exit;
    }

    public function delete() {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $result = $this->new_model->distroy($id);
        echo json_encode($result);
        exit;
    }

}

?>