<?php

class Hello_world extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Hello_model');
        $this->load->helper('form');
    }

    public function index() {
        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('layout/body');
        $this->load->view('layout/footer');
    }

    public function save() {
        $result = array();
        $id = $_POST['n_id'];
        if (!empty($_POST)) {
            if (!isset($_FILES['n_img']['temp_name'])) {
                $img = $_FILES;
                $config = array(
                    'upload_path' => "D:/wamp64/www/CI/assets/images",
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => TRUE,
                    'max_size' => 2048,
                );
                $this->load->library('upload', $config);
                $this->upload->do_upload('n_img');
                $file_name = $this->upload->data();
                $data_img = $file_name['file_name'];
            } else {
                $data_img = $_POST['n_imghiden'];
                echo "image is not set";
                exit;
            }

            $post = $this->input->post();

            $data = array(
                's_img' => $data_img,
                's_name' => $this->input->post('n_name'),
                's_mobile' => $this->input->post('n_num'),
                's_gender' => $this->input->post('n_radio'),
                's_city' => $this->input->post('n_city'),
                's_state' => $this->input->post('n_state'),
                's_country' => $this->input->post('n_country'),
            );
            if (isset($id) && $id != '') {
                $this->Hello_model->update_data($id, $data);
            } else {
                $this->Hello_model->insert_data($data);
            }
        }

        echo json_encode($result);
        exit;
    }

    public function view() {
        $column = array(
            0 => 's_img',
            1 => 's_name',
            2 => 's_mobile',
            3 => 's_gender',
            4 => 's_city',
            5 => 's_state',
            6 => 's_country'
        );
        $this->Hello_model->start = isset($_POST['start']) ? $_POST['start'] : '';
        $this->Hello_model->length = isset($_POST['length']) ? $_POST['length'] : '';
        $this->Hello_model->search = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
        $this->Hello_model->orderby = isset($_POST['order'][0]['column']) ? $column[$_POST['order'][0]['column']] : '';
        $this->Hello_model->ordernum = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : '';
        $this->Hello_model->count = TRUE;
        $count = $this->Hello_model->get_Data();

        $this->Hello_model->count = FALSE;
        $student = $this->Hello_model->get_Data();
        $data = array();
        foreach ($student as $user) {
            if ($user['s_img'] != '') {
                $user['s_img'] = $user['s_img'];
            } else {
                $user['s_img'] = '8.png';
            }
            $temp['s_img'] = "<img width='35px' height='35px' src='" . base_url() . "assets/images/" . $user['s_img'] . "'>";
            $temp['s_name'] = $user['s_name'];
            $temp['s_mobile'] = $user['s_mobile'];
            $temp['s_gender'] = $user['s_gender'];
            $temp['s_city'] = $user['s_city'];
            $temp['s_state'] = $user['s_state'];
            $temp['s_country'] = $user['s_country'];
            $temp['action'] = "<button class='edit' data-id='" . $user['s_id'] . "' data-toggle='modal' data-target='#i_form'>Edit</button>        <button class='delete' data-id='" . $user['s_id'] . "'>Delete</button>";
            $data[] = $temp;
        }
        $json_data = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => intval($count),
            "recordsFiltered" => intval($count),
            "data" => $data,
        );
        echo json_encode($json_data);
        exit;
    }

    public function edit() {
        if (!empty($_POST)) {
            $id = $_POST['id'];
            $user_data = $this->Hello_model->edit_data($id);
            $result['status'] = 1;
            $result['content'] = $user_data;
            echo json_encode($result);
            exit;
        }
    }

    public function delete() {
        if (!empty($_POST)) {
            $id = $_POST['id'];
            $user_data = $this->Hello_model->delete_data($id);
            $result['status'] = 1;
            $result['content'] = $user_data;
            echo json_encode($result);
            exit;
        }
    }

}

?>