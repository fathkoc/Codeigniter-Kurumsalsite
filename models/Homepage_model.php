<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage_model extends CI_Model {

    public function get_slider()
    {
        $this->db->from('slider')->where(['deleted' => 0, 'status' => 1]);
        $this->db->order_by('position', 'ASC');
        $return_query = $this->db->get();
        if($return_query->num_rows() > 0) {
            return $return_query->result();
        } else {
            return false;
        }
    }

    public function get_about()
    {
        $this->db->from('about');
        if(empty($this->session->userdata('langue'))) {
            $this->db->where(['lang' => 1]);
        } else {
            $this->db->where(['lang' => $this->session->userdata('langue')]);
        }
        $return_query = $this->db->get();
        if($return_query->num_rows() > 0) {
            return $return_query->row();
        } else {
            return false;
        }
    }
    public  function get_contact()
    {
        $this->db->from('contact');
        $return_query = $this->db->get();
        if($return_query->num_rows() > 0) {
            return $return_query->row();
        } else {
            return false;
        }
    }
    public function get_site_settings($id)
    {
        $this->db->select('title,description');
        $this->db->from('site_settings')->where(['id' => $id]);
        $return_query = $this->db->get();
        if($return_query->num_rows() > 0) {
            return  $return_query->row();
        } else {
            return false;
        }
    }
    public function get_address(){
        $this->db->from('contact');
        $return_query = $this->db->get();
        if($return_query->num_rows() > 0) {
            return $return_query->row();
        } else {
            return false;
        }
    }
    public function gets_about(){
        $this->db->from('index_about');
        $return_query = $this->db->get();
        if($return_query->num_rows() > 0) {
            return $return_query->row();
        } else {
            return false;
        }
    }
    public function get_abouts(){
        $this->db->from('about');
        $return_query = $this->db->get();
        if($return_query->num_rows() > 0) {
            return $return_query->row();
        } else {
            return false;
        }
    }
    public function get_product(){
        $this->db->from('product')->where(['deleted'=>0,'status'=>1]);
        $this->db->order_by('position', 'ASC');
        $return_query=$this->db->get();
        if ($return_query->num_rows() > 0){
            return $return_query->result();
        }
        else{
            return false;
        }
    }
    public function row_product($slug=''){
        $this->db->select('p.slug,p.deleted,p.status,p.id,m.urun_id,m.image_path,p.name,m.name as m_name');
        $this->db->from('product p')->where(['p.deleted'=>0,'p.status'=>1,'p.slug'=>$slug,'m.deleted'=>0,'m.status'=>1]);
        $this->db->order_by('p.position', 'ASC');
        $this->db->join('Marka m','p.id=m.urun_id');
        $return_query=$this->db->get();
        if ($return_query->num_rows() > 0){
            return $return_query->result();
        }
        else{
            return false;
        }
    }
    public function tekliproduct($slug){
        $this->db->from('product')->where(['deleted'=>0,'status'=>1,'slug'=>$slug]);
        $this->db->order_by('position', 'ASC');
        $return_query=$this->db->get();
        if ($return_query->num_rows() > 0){
            return $return_query->row();
        }
        else{
            return false;
        }

    }
    public function get_catalog(){
        $this->db->from('catalog')->where(['deleted'=>0,'status'=>1]);
        $this->db->order_by('position', 'ASC');
        $return_query = $this->db->get();
        if($return_query->num_rows() > 0) {
            return $return_query->result();
        } else {
            return false;
        }
    }
    public function get_marka(){
        $this->db->from('Marka')->where(['deleted'=>0,'status'=>1]);
        $return_query = $this->db->get();
        if($return_query->num_rows() > 0) {
            return $return_query->result();
        } else {
            return false;
        }
    }

}