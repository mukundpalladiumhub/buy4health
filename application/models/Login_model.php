<?php

class Login_model extends CI_Model {

    private $email;
    private $password;

    public function login($email, $password) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $this->db->where('status', '1');
        $this->db->where('role_id', '1');
        $this->db->where('password', $password);
        $user = $this->db->get()->row_array();
        return $user;
    }

    public function userbycode($id) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $id);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function check_id($data) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $data);
        $nos = $this->db->get()->row_array();
        return $nos;
    }

    public function update_password($password, $id) {
        $this->db->set('password', $password);
        $this->db->set('status', '1');
        $this->db->where('id', $id);
        $this->db->update('users');
    }

}

?>