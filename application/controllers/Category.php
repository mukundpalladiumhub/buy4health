<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('category_model');
    }

    public function index() {

        if ($this->session->userdata('user_id')) {
            $abcd = $this->session->get_userdata('user_name');
            $data['title'] = 'Category';
            $this->load->view('layout/header.php', $data);
            $this->load->view('layout/sidebar.php');
            $this->load->view('category_view.php');
            $this->load->view('layout/footer.php');
        } else {
            return redirect('login');
        }

        $post = $this->input->post();

        if (!empty($post)) {
            $colnum = array(
                0 => 'site_id',
                1 => 'category_name',
                2 => 'category_tag',
                3 => 'status',
            );

            $this->category_model->site_id = isset($post['site_id']) ? $post['site_id'] : '';
            $this->category_model->search = isset($post['search']['value']) ? $post['search']['value'] : '';
            $this->category_model->start = isset($post['start']) ? $post['start'] : '';
            $this->category_model->length = isset($post['length']) ? $post['length'] : '';
            $this->category_model->column = isset($post['order'][0]['column']) ? $colnum[$post['order'][0]['column']] : '';
            $this->category_model->dire = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : '';

            $conn = FALSE;
            $count = $this->category_model->CategoryList($conn);
            $conn = true;
            $result = $this->category_model->CategoryList($conn);

            $category_data = array();
            foreach ($result as $array) {
                $site = "";
                if (isset($array['site_id']) && $array['site_id'] == RENT4HEALTHID) {
                    $site = "Rent4health";
                } else if (isset($array['site_id']) && $array['site_id'] == BUY4HEALTHID) {
                    $site = "Buy4health";
                }

                $image = "";
                if (isset($array['category_image']) && $array['category_image'] != "") {
                    $image = $array['category_image'];
                } else {
                    $image = base_url('assets/images/No-Image.png');
                }

                $id = $array['id'];
                $data['site_id'] = $site;
                $data['category_name'] = $array['category_name'];
                $data['category_tag'] = $array['category_tag'];
                $data['category_image'] = '<img src="' . $image . '" alt="No Image" height="42" width="42" />';
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