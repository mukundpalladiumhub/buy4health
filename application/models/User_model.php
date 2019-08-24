<?php

class User_model extends CI_Model {

    public $search;
    public $length;
    public $start;
    public $column;
    public $dire;

    public function __construct() {
        parent::__construct();
    }

    public function UserList($conn) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('role_id',USER_ROLE);
        
        $search = $this->search;
        $length = $this->length;
        $start = $this->start;
        $column = $this->column;
        $dire = $this->dire;
        if (isset($search) && $search != '') {
            $this->db->like('first_name', $search);
            $this->db->or_like('last_name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('address1', $search);
            $this->db->or_like('zipcode', $search);
            $this->db->or_like('city', $search);
            $this->db->or_like('state', $search);
            $this->db->or_like('mobile', $search);
            $this->db->or_like('phone', $search);
        }
        if (isset($column) && $column != '') {
            $this->db->order_by($column, $dire);
        }
        if ($conn == FALSE) {
            $nos = $this->db->get()->num_rows();
            return $nos;
        }
        if (isset($start) && $start != '') {
            $this->db->limit($length, $start);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function change_password($old_pass, $new_pass, $id) {
        $this->db->where('id', $id);
        $nos = $this->db->get('users')->row_array();
        if ($nos['password'] == $old_pass) {
            $this->db->set('password', $new_pass);
            $this->db->where('id', $id);
            $this->db->update('users');
            return $nos['first_name'];
        } else {
            return $old_pass;
        }
    }

}

?>