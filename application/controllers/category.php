<?php

class Category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('category_model');
    }

    public function index() {
        if ($this->session->userdata('user_id')) {
            $abcd = $this->session->get_userdata('user_name');
            $this->load->view('layout/header.php');
            $this->load->view('layout/sidebar.php');
            $this->load->view('category_view.php');
            $this->load->view('layout/footer.php');
        } else {
            return redirect('login');
        }
        $post = $this->input->post();
        if (!empty($post)) {
            $this->category_model->search = isset($post['search']['value']) ? $post['search']['value'] : '';
            $this->category_model->start = isset($post['start']) ? $post['start'] : '';
            $this->category_model->length = isset($post['length']) ? $post['length'] : '';
            $colnum = array(
                0 => 'category_name',
                1 => 'category_tag',
                2 => 'category_image',
                3 => 'status',
            );
            $this->category_model->column = isset($post['order'][0]['column']) ? $colnum[$post['order'][0]['column']] : '';
            $this->category_model->dire = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : '';
            $conn = FALSE;
            $count = $this->category_model->CategoryList($conn);
            $conn = true;
            $result = $this->category_model->CategoryList($conn);
            $category_data = array();
            foreach ($result as $array) {
                if ($array['status'] == 1) {
                    $array['status'] = 'Active';
                } else {
                    $array['status'] = 'Inactive';
                }
                $id = $array['id'];
                $data['category_name'] = $array['category_name'];
                $data['category_tag'] = $array['category_tag'];
                $data['category_image'] = $array['category_image'];
                $data['status'] = $array['status'];
                $category_data[] = $data;
            }
            $json = array(
                "draw" => $_POST['draw'],
                "data" => $category_data,
                "recordsFiltered" => intval($count),
                "recordsTotal" => intval($count),
            );
            echo json_encode($json);
            exit;
        }
    }

}

?>