<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');
    }

    public function index() {
        if ($this->session->userdata('user_id')) {
            $count = $this->dashboard_model->UserCounts();
            $orders = $this->dashboard_model->RecentOrders();
            $header['title'] = 'Dashboard';
            $data['count'] = $count;
            $data['orders'] = $orders;
            $this->load->view('layout/header.php',$header);
            $this->load->view('layout/sidebar.php');
            $this->load->view('dashboard.php', $data);
            $this->load->view('layout/footer.php');
        } else {
            return redirect('login');
        }
    }
}

?>