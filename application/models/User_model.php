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
        $this->db->from('user_details');
        $search = $this->search;
        $length = $this->length;
        $start = $this->start;
        $column = $this->column;
        $dire = $this->dire;
        if (isset($search) && $search != '') {
            $this->db->like('full_name', $search);
            $this->db->or_like('user_name', $search);
            $this->db->or_like('password', $search);
        }
        if (isset($column) && $column != '') {
            $this->db->order_by($column, $dire);
        }
        if (isset($start) && $start != '') {
            $this->db->limit($length, $start);
        }
        if ($conn == FALSE) {
            $nos = $this->db->get()->num_rows();
            return $nos;
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function change_password($old_pass, $new_pass, $id) {
        $this->db->where('id', $id);
        $nos = $this->db->get('user_details')->row_array();
        if ($nos['password'] == $old_pass) {
            $this->db->set('password', $new_pass);
            $this->db->where('id', $id);
            $this->db->update('user_details');
            return $nos['full_name'];
        } else {
            return $old_pass;
        }
    }

}

?>