<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage_model extends CI_Model {

    public function aboutupdate($post){
        $this->db->set($post)->WHERE(['id'=>$post->id])->update('index_about');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    public function aboutlist(){
        $this->db->from('index_about')->where(['deleted' => 0]);
        $return_query = $this->db->get();
        if($return_query->num_rows() > 0) {
            return $return_query->row();
        } else {
            return false;
        }
    }


}