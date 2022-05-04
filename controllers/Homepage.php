<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Homepage extends Veripay_Controller
{
    function __construct()
    {
        parent:: __construct();

        $this->result = new StdClass();
        $this->result->status = false;
        $this->load->model($this->router->fetch_class() . '_model', 'model');
    }

    public function response()
    {
        echo json_encode($this->result);
        exit();
    }
    public function index()
    {    $data=new stdClass();
        $data->site_settings = new stdClass();
        $data->kur=$this->kurcekme();
        $data->aboutus=$this->model->get_abouts();
        $data->slider=$this->model->get_slider();
        $data->contact=$this->model->get_address();
        $data->about=$this->model->gets_about();
        $data->product=$this->model->get_product();
        $data->marka=$this->model->get_marka();
        $data->site_settings = $this->model->get_site_settings(1);
        $data->active="index";

        $this->load->view('front/header',$data);
        $this->load->view('front/index');
        $this->load->view('front/footer');
    }
    public function about(){
        $data=new stdClass();
        $data->kur=$this->kurcekme();
        $data->site_settings = new stdClass();
        $data->slider=$this->model->get_slider();
        $data->contact=$this->model->get_address();
        $data->about=$this->model->gets_about();
        $data->aboutus=$this->model->get_abouts();
        $data->product=$this->model->get_product();
        $data->marka=$this->model->get_marka();
        $data->site_settings = $this->model->get_site_settings(5);
        $data->active="about";

        $this->load->view('front/header',$data);
        $this->load->view('front/about');
        $this->load->view('front/footer');
    }
    public function product(){
        $data=new stdClass();
        $data->site_settings = new stdClass();
        $data->kur=$this->kurcekme();
        $data->slider=$this->model->get_slider();
        $data->contact=$this->model->get_address();
        $data->about=$this->model->gets_about();
        $data->aboutus=$this->model->get_abouts();
        $data->product=$this->model->get_product();
        $data->site_settings = $this->model->get_site_settings(2);
        $data->active="product";

        $this->load->view('front/header',$data);
        $this->load->view('front/products');
        $this->load->view('front/footer');
    }
    public function contact(){
        $data=new stdClass();
        $data->site_settings = new stdClass();
        $data->kur=$this->kurcekme();
        $data->slider=$this->model->get_slider();
        $data->contact=$this->model->get_address();
        $data->about=$this->model->gets_about();
        $data->aboutus=$this->model->get_abouts();
        $data->product=$this->model->get_product();
        $data->site_settings = $this->model->get_site_settings(4);
        $data->active="contact";

        $this->load->view('front/header',$data);
        $this->load->view('front/contact');
        $this->load->view('front/footer');
    }
    public function marka($slug=''){
        $data=new stdClass();
        $data->site_settings = new stdClass();
        $data->kur=$this->kurcekme();
        $data->slider=$this->model->get_slider();
        $data->contact=$this->model->get_address();
        $data->about=$this->model->gets_about();
        $data->aboutus=$this->model->get_abouts();
        $data->product=$this->model->get_product();
        $data->site_settings = $this->model->get_site_settings(2);
        $data->products=$this->model->row_product($slug);
        $data->productrow=$this->model->tekliproduct($slug);
        $data->active="marka";

        $this->load->view('front/header',$data);
        $this->load->view('front/product-detail');
        $this->load->view('front/footer');
    }
    public function catalog(){
        $data=new stdClass();
        $data->site_settings = new stdClass();
        $data->kur=$this->kurcekme();
        $data->slider=$this->model->get_slider();
        $data->contact=$this->model->get_address();
        $data->about=$this->model->gets_about();
        $data->aboutus=$this->model->get_abouts();
        $data->product=$this->model->get_product();
        $data->catalog=$this->model->get_catalog();
        $data->site_settings = $this->model->get_site_settings(3);
        $data->active="catalog";
        //prex($data->catalog);
        $this->load->view('front/header',$data);
        $this->load->view('front/catalog');
        $this->load->view('front/footer');
    }
}