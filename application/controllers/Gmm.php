<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gmm extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	/*	if(!isset($_SESSION['user_id']))
		{
			$this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('login');
		}*/

		$this->load->helper('url');
		$this->load->model('data_model');
		$this->load->library('permission');
        $this->load->library('nusoap');
	}


     function index($info = '-')
    {
    	$data = explode('-',$info);

    	/*$decodeName = base64_decode($data[0]);
    	$decodePoliza = base64_decode($data[1]);*/

    	/*$encryptrName = base64_encode($data[0]);
    	$encryptrPoliza = base64_encode($data[1]);*/

        $this->load->view('header');
    	$this->load->view('gmm/index',array('nombre' => $data[0],
                                            'poliza' => $data[1] ));
    	$this->load->view('footer');	
    }

   /* public function buscar()
    {
    	$server = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    	$name = explode('/', $server);

    	echo 'hola '.$name[3];
    }*/




}