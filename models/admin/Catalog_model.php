<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalog_model extends CI_Model
{
public function insert($post){
    $this->db->set($post)->insert('catalog');
    if($this->db->affected_rows() > 0){
        return true;
    }
    else{
        return false;
    }
}
public function get_catalog(){
    $this->db->from('catalog')->where(['deleted'=>0]);
    $return_query=$this->db->get();
    if ($return_query->num_rows() > 0){
        return $return_query->result();
    }
    else{
        return false;
    }
}
public function position($post){
    $this->db->set($post)->WHERE(['id'=>$post->id])->update('catalog');
    if ($this->db->affected_rows() > 0) {
        return true;
    }
    else {
        return false;
    }
}
public function status($post){
    $this->db->set(['status'=>$post->status])->WHERE(['id'=>$post->id])->update('catalog');
    if ($this->db->affected_rows() > 0) {
        return true;
    }
    else {
        return false;
    }
}
public function deleted($post){
    $this->db->set(['deleted'=>1])->WHERE(['id'=>$post->id])->update('catalog');
    if ($this->db->affected_rows() > 0) {
        return true;
    }
    else {
        return false;
    }
}
public function row_catalog($id){
    $this->db->from('catalog')->where(['deleted'=>0,'id'=>$id]);
    $return_query=$this->db->get();
    if ($return_query->num_rows() > 0){
        return $return_query->row();
    }
    else{
        return false;
    }
}
public function update($post){
    $this->db->set($post)->WHERE(['id'=>$post->id])->update('catalog');
    if ($this->db->affected_rows() > 0) {
        return true;
    }
    else {
        return false;
    }
}
}
