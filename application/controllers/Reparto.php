<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reparto extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		if(!isset($_SESSION['user_id'])){
			$this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
			return redirect('login');
		}

		$this->load->library('permission');
		$this->load->library('curl');
		$this->load->helper('url');
	}

	public function index(){

		$this->load->view('header');
		$this->load->view('reparto/index');
		$this->load->view('footer');
	}
}