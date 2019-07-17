<?php

Class Hello_model extends CI_Model {

    public $orderby;
    public $search;
    public $start;
    public $ordernum;
    public $count;
    public $length;

    public function __construct() {
        parent::__construct();
    }

    public function get_Data() {
        $this->db->select('*');
        $this->db->from('sign_up');
        if ($this->count == TRUE) {
            $result = $this->db->get()->num_rows();
            return $result;
        } else {
            if (isset($this->search) && $this->search != '') {
                $this->db->like('s_name', $this->search);
                $this->db->or_like('s_mobile', $this->search);
                $this->db->or_like('s_gender', $this->search);
                $this->db->or_like('s_city', $this->search);
                $this->db->or_like('s_state', $this->search);
                $this->db->or_like('s_country', $this->search);
            }
            if (isset($this->orderby) && $this->orderby != '' && isset($this->ordernum) && $this->ordernum != '') {
                $this->db->order_by($this->orderby, $this->ordernum);
            }
            $this->db->limit($this->length, $this->start);
            $abc = $this->db->get()->result_array();
            return $abc;
        }
    }

    public function edit_data($id) {
        $this->db->select('*');
        $this->db->from('sign_up');
        $this->db->where('s_id', $id);
        $abc = $this->db->get()->row();
        return $abc;
    }

    public function delete_data($id) {
        $this->db->where('s_id', $id);
        $this->db->delete('sign_up');
    }

    public function update_data($id, $data) {
        $this->db->set($data);
        $this->db->where('s_id', $id);
        $this->db->update('sign_up', $data);
    }

    public function insert_data($data) {
        $this->db->insert('sign_up', $data);
    }

}

?> 