<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marka_model extends CI_Model
{
public function product(){
    $this->db->from('product')->where(['deleted'=>0]);
    $return_query=$this->db->get();
    if ($return_query->num_rows() > 0){
        return $return_query->result();
    }
    else{
        return false;
    }
}
public function insertmarka($post){
    $this->db->set($post)->insert('Marka');
    if($this->db->affected_rows() > 0){
        return true;
    }
    else{
        return false;
    }
}
public function get_marka(){
    $this->db->from('Marka')->where(['deleted'=>0]);
    $return_query=$this->db->get();
    if ($return_query->num_rows() > 0){
        return $return_query->result();
    }
    else{
        return false;
    }
}
public function deleted($post){
    $this->db->set(['deleted'=>1])->WHERE(['id'=>$post->id])->update('Marka');
    if ($this->db->affected_rows() > 0) {
        return true;
    }
    else {
        return false;
    }
}
public function status($post){
    $this->db->set(['status'=>$post->status])->WHERE(['id'=>$post->id])->update('Marka');
    if ($this->db->affected_rows() > 0) {
        return true;
    }
    else {
        return false;
    }
}
public function row_marka($id){
    $this->db->from('Marka')->where(['deleted'=>0,'id'=>$id]);
    $return_query=$this->db->get();
    if ($return_query->num_rows() > 0){
        return $return_query->row();
    }
    else{
        return false;
    }
}
public function markaupdate($post){
    $this->db->set($post)->WHERE(['id'=>$post->id])->update('Marka');
    if ($this->db->affected_rows() > 0) {
        return true;
    }
    else {
        return false;
    }
}

}