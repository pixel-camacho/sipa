<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class editar extends CI_Controller
{
    function __contruct()
    {
        parent::__contruct();
    if(!isset($_SESSION['user_id']))
    {
        $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('login');
    }

    $this->load->helper('url');
    $this->load->model('data_model');
	$this->load->library('permission');
    $this->load->library('nusoap');

    }


    function index()
    {
        $this->load->view('header');
        $this->load->view('editar/index');
        $this->load->view('footer');
    }

    


}