<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_model extends CI_Model {
    public function add_message($post_data)
    {
        $this->db->set($post_data)->insert('messages');
        if ($this->db->affected_rows() > 0) {
            return true;
        }else {
            return false;
        }
    }


}