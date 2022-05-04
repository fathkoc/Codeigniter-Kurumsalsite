<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends Veripay_Controller
{

    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
        $this->result = new StdClass();
        $this->result->status = false;
        $this->load->model('admin/' . $this->router->fetch_class() . '_model', 'model');
    }

    public function response()
    {
        echo json_encode($this->result);
        exit();
    }
    public function remove_images()
    {
        $this->session->unset_userdata('images');
        $this->session->unset_userdata('cover_images');
        $this->session->unset_userdata('images2');
        $this->session->unset_userdata('video');
        $this->result->status = true;
        $this->response();
    }




}
