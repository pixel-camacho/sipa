<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//Load libruary for API
class Preregistro extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('login');
        }
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->model('cliente_model', 'cliente');
        $this->load->library('permission');
        $this->load->library('nusoap');
    }

    public function index() {
		// Permission::grant(uri_string());
        $this->load->view('header');
        $this->load->view('preregistro/index');
        $this->load->view('footer');
    }
 

}
