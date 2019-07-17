<?php

class New_model extends CI_Model {

    public $search;
    public $length;
    public $start;
    public $column;
    public $dire;

    public function __construct() {
        parent::__construct();
    }

    public function add($data) {
        $this->db->insert('user_details', $data);
        return $data['full_name'];
    }

    public function update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('user_details', $data);
        return $data['full_name'];
    }

    public function show($conn) {
        $this->db->select('*');
        $this->db->from('user_details');
        if ($conn == FALSE) {
            $nos = $this->db->get()->num_rows();
            return $nos;
        } else {
            $search = $this->search;
            $length = $this->length;
            $start = $this->start;
            $column = $this->column;
            $dire = $this->dire;

            if (isset($search) && $search != '') {
                $this->db->like('profile_image', $search);
                $this->db->or_like('full_name', $search);
                $this->db->or_like('mobile_no', $search);
                $this->db->or_like('gender', $search);
                $this->db->or_like('city', $search);
                $this->db->or_like('state', $search);
                $this->db->or_like('user_name', $search);
                $this->db->or_like('password', $search);
            }

            if (isset($column) && $column != '') {
                $this->db->order_by($column, $dire);
            }

            if (isset($start) && $start != '') {
                $this->db->limit($length, $start);
            }
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function fill($id) {
        $query = $this->db->get_where('user_details', array('id' => $id))->row();
        return $query;
    }

    public function distroy($id) {
        $this->db->where('id', $id);
        $this->db->delete('user_details');
        return $id;
    }
    public function change_pass($old_pass,$new_pass,$id) {
        $this->db->where('id',$id);
        $nos = $this->db->get('user_details')->row_array();
        if($nos['password'] == $old_pass){
            $this->db->set('password', $new_pass);
            $this->db->where('id',$id);
            $this->db->update('user_details');
            return $nos['full_name'];
        } else{
            return $old_pass;
        }
    }

}

?>