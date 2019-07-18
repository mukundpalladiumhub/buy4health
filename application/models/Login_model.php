<?php

class Login_model extends CI_Model {

    private $user_name;
    private $password;

    public function login($user_name, $password) {
        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->where('user_name', $user_name);
        $this->db->where('status', '1');
        $this->db->where('password', $password);
        $nos = $this->db->get();
        if ($nos->num_rows()) {
            return $nos->row()->id;
        } else {
            return FALSE;
        }
    }

    public function alltable() {
        $this->db->select('*');
        $this->db->from('user_details');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function signup($data) {
        $this->db->insert('user_details', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function verify($code) {
        $this->db->set('status', '1');
        $this->db->where('code', $code);
        $this->db->update('user_details');
        return $code;
    }

    public function userbycode($code) { // details
        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->where('code', $code);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function userbyid($id) {
        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->where('id', $id);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function check_id($data) {
        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->where('user_name', $data);
        $nos = $this->db->get()->row_array();
        return $nos;
    }

    public function update_code($code, $user_name) {
        $this->db->set('code', $code);
        $this->db->where('user_name', $user_name);
        $this->db->update('user_details');
    }

    public function update_password($password, $id) {
        $this->db->set('password', $password);
        $this->db->set('status', '1');
        $this->db->where('id', $id);
        $this->db->update('user_details');
    }

}

?>