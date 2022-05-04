<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
use WebPConvert\WebPConvert;
class Marka extends Veripay_Controller
{

    function __construct()
    {
        parent:: __construct();

        $this->result = new StdClass();
        $this->result->status = false;
        $this->load->model('admin/' . $this->router->fetch_class() . '_model', 'model');

    }

    public function response()
    {
        echo json_encode($this->result);
        exit();
    }

    public function index()
    {
        $this->admin_logout();
        $admin_info = $this->get_user();
        $data = new stdClass();
        $post_data = new StdClass();
        $data->admin_info = $admin_info;
        $data->active = "marka";
        $data->user = $this->session->userdata('admin_info');
        $data->product=$this->model->product();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/markaekle');
        $this->load->view('admin/footer');
    }
    public function insertmarka(){
        $this->form_validation->set_rules('name', 'name', 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('urun_id', 'urun_id', 'required|xss_clean');
        if ($this->form_validation->run() != FALSE) {
            $post = new stdClass();
            $post->name = $this->input->post('name', true);
            $post->urun_id = $this->input->post('urun_id', true);
            if ($this->session->userdata('images')) {
                $post->image_path = $this->session->userdata('images');
                $this->session->unset_userdata('images');
            }
            if ($this->model->insertmarka($post)) {
                $this->result->status = true;
                $this->response();
            } else {
                $this->result->error = "Ekleme İşlemi Esnasında Bir Hata Oluştu Lütfen Tekrar Deneyin.";
                $this->response();
            }
        } else {
            $this->result->error = validation_errors();
            if (!empty($this->result->error)) {
                $this->response();
            }

        }
    }
    public function listmarka(){
        $this->admin_logout();
        $admin_info = $this->get_user();
        $data = new stdClass();
        $post_data = new StdClass();
        $data->admin_info = $admin_info;
        $data->active = "marka";
        $data->user = $this->session->userdata('admin_info');
        $data->marka=$this->model->get_marka();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/markalistele');
        $this->load->view('admin/footer');
     
    }
    public function deleted(){
        $this->form_validation->set_rules('id','id','xss_clean');
        if ($this->form_validation->run() !=FALSE){
            $post=new stdClass();
            $post->id=$this->input->post('id',true);
            if ($this->model->deleted($post)){
                $this->result->status = true;
                $this->response();
            } else{
                $this->result->error = "Ekleme İşlemi Esnasında Bir Hata Oluştu Lütfen Tekrar Deneyin.";
                $this->response();
            }
        }
        else {
            $this->result->error = validation_errors();
            $this->response();
        }

    }
    public function status(){
        $this->form_validation->set_rules('status','status','xss_clean|required|integer');
        $this->form_validation->set_rules('id','id','xss_clean|required|integer');
        if ($this->form_validation->run() !=FALSE){
            $post=new stdClass();
            $post->id=$this->input->post('id',true);
            $post->status=$this->input->post('status',true);
            if ($this->model->status($post)){
                $this->result->url = site_url('yonetim-paneli/marka-listele');
                $this->result->status = true;
                $this->response();
            }
            else{
                $this->result->error = "Ekleme İşlemi Esnasında Bir Hata Oluştu Lütfen Tekrar Deneyin.";
                $this->response();
            }
        } else{
            $this->result->error = validation_errors();
            $this->response();
        }

    }
    public function update($id=''){
        $data=new stdClass();
        $this->admin_logout();
        $admin_info = $this->get_user();
        $data = new stdClass();
        $post_data = new StdClass();
        $data->admin_info = $admin_info;
        $data->active = "marka";
        $data->user = $this->session->userdata('admin_info');
        if ($_POST){
            $this->form_validation->set_rules('name','name','required|xss_clean|max_length[200]');
            $this->form_validation->set_rules('id','id','required|xss_clean|integer');
            if ($this->form_validation->run() !=FALSE){
                $post=new stdClass();
                $post->name=$this->input->post('name',true);
                $post->id=$this->input->post('id',true);
                if ($this->session->userdata('images')) {
                    $post->image_path = $this->session->userdata('images');
                    $this->session->unset_userdata('images');
                }
                if ($this->model->markaupdate($post)){
                    $this->result->url = site_url('yonetim-paneli/marka-listele');
                    $this->result->status = true;
                    $this->response();
                }
                else {
                    $this->result->error = "Ekleme İşlemi Esnasında Bir Hata Oluştu Lütfen Tekrar Deneyin.";
                    $this->response();
                }
            }
        }
        $data->marka=$this->model->row_marka($id);

        $this->load->view('admin/header',$data);
        $this->load->view('admin/markaguncelle');
        $this->load->view('admin/footer');

    }

    public function add_image()
    {
        $this->load->library('image_lib');
        $config['upload_path'] = 'assets/uploads/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = 1024;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file')) {
            $this->output->set_status_header('404');
            print strip_tags($this->upload->display_errors());
            exit;
        } else {
            $image_data = $this->upload->data();
            $image_config = array(
                'image_library' => 'gd2',
                'source_image' => $image_data['full_path'],
                'maintain_ratio' => TRUE,
                'width' => 500,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($image_config);
            $this->image_lib->resize();

            $uploaded_image = 'assets/uploads/' . $this->upload->data('file_name');
            $source = 'assets/uploads/' . $this->upload->data('file_name');
            $destination = $source . '.webp';
            $options = [
                'fail' => 'throw',
                'fail-when-fail-fails' => 'throw',
                'serve-original' => false,
                'reconvert' => false,
                'show-report' => false,
                'size-in-percentage' => 90,
                'serve-image' => [
                    'headers' => [
                        'cache-control' => true,
                        'content-length' => true,
                        'content-type' => true,
                        'expires' => false,
                        'last-modified' => true,
                        'vary-accept' => false
                    ],
                    'cache-control-header' => 'public, max-age=31536000',
                ],
                'convert' => [
                    'quality' => 85,
                ],
                'converter-options' => [
                    'vips' => [
                        'quality' => 72
                    ],
                ]
            ];
            WebPConvert::convert($source, $destination, $options);
            $this->session->set_userdata('images', $uploaded_image);
            pre($this->session->userdata('images'));
        }

    }
}