<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
use WebPConvert\WebPConvert;
class About extends Veripay_Controller
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
        $data->active = "about";
        $data->user=$this->session->userdata('admin_info');
        $data->about = $this->model->get_about();

        $this->form_validation->set_rules('title', 'Başlık', 'required|trim|max_length[250]|xss_clean');
        $this->form_validation->set_rules('text', 'Metin', 'required');
        $this->form_validation->set_rules('second_title', 'İkinci Başlık', 'required|trim|max_length[250]|xss_clean');
        $this->form_validation->set_rules('second_text', 'İkinci Metin', 'xss_clean');
        $this->form_validation->set_rules('third_title', 'Üçüncü başlık', 'required|trim|max_length[250]|xss_clean');
        $this->form_validation->set_rules('third_text', 'Üçüncü Metin Başlık', 'xss_clean');
        if ($this->form_validation->run() != false) {
            $post_data->title = $this->input->post('title', true);
            $post_data->text = $this->input->post('text', false);
            $post_data->second_title = $this->input->post('second_title', true);
            $post_data->second_text = $this->input->post('second_text', true);
            $post_data->third_title = $this->input->post('third_title', true);
            $post_data->third_text = $this->input->post('third_text', true);
            $post_data->vizyon = $this->input->post('vizyon', false);
            if ($this->session->userdata('images')) {
                $post_data->image_path = $this->session->userdata('images');
                $this->session->unset_userdata('images');
            }
            if ($this->session->userdata('images2')) {
                $post_data->image_path_2 = $this->session->userdata('images2');
                $this->session->unset_userdata('images2');
            }
            if ($this->session->userdata('images3')) {
                $post_data->image_path_3 = $this->session->userdata('images3');
                $this->session->unset_userdata('images3');
            }
            if ($this->model->update($post_data)) {
                $this->result->status = true;
                $this->response();
            } else {
                $this->result->error = "Ekleme İşlemi Esnasında Bir Hata Oluştu Lütfen Tekrar Deneyin.";
                $this->response();
            }
        } else {
            $this->result->error = validation_errors();
            if(!empty($this->result->error)) {
                $this->response();
            }
        }
        $this->load->view('admin/header', $data);
        $this->load->view('admin/about');
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

    public function add_image_2()
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
                'width' => 650,
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
            $this->session->set_userdata('images2', $uploaded_image);
            pre($this->session->userdata('images2'));
        }
    }
    public function add_image_3()
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
                'width' => 450,
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
            $this->session->set_userdata('images3', $uploaded_image);
            pre($this->session->userdata('images3'));
        }

    }



}