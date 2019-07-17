<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Makepayment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_id')) {
            
        } else {
            return redirect('login_form/form');
        }
        $this->load->library("session");
        $this->load->helper('url');
    }

    public function index() {
        $abcd = $this->session->get_userdata('user_name');
        $this->load->view('new/header.php', $abcd);
        $this->load->view('new/sidebar.php', $abcd);
        $this->load->view('new/my_stripe');
        $this->load->view('new/footer.php');
    }

    public function stripePost() {
        require_once('application/libraries/stripe-php/init.php');
        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
        $b = \Stripe\Charge::create([
                    "amount" => 10 * 100,
                    "currency" => "usd",
                    "source" => $this->input->post('stripeToken'),
                    "description" => "Test payment from itsolutionstuff.com."
        ]);
        echo "<pre>";
        print_r($b);
        exit;
        $this->session->set_flashdata('success', 'Payment made successfully.');
        redirect('/my-stripe', 'refresh');
    }

}
