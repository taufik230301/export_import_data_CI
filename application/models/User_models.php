<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_models extends CI_Model {

    public function get_user($table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join('user_level', 'user.id_user_level = user_level.id_user_level');
        return $this->db->get()->result_array();
    }

    public function tambah($data){
        return $this->db->insert('user', $data);
    }

    public function update($data, $id){
        $this->db->where('id', $id);
        return $this->db->update('user', $data);
    }

    public function delete($id){
        $this->db->where('id', $id);
        return $this->db->delete('user');
    }

    public function cek_login($username){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('user_level', 'user.id_user_level = user_level.id_user_level');
        $this->db->where('username', $username);
        return $this->db->get()->row_array();
    }

    public function insert_excel($data){
        return $this->db->insert('user', $data);
        if($this->db->affected_rows()>1){
            return 1;
        }else{
            return 0;
        }
    }
    
}