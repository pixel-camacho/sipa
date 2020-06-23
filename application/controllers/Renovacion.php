<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//Load libruary for API
class Renovacion extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('login');
        }
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->model('periodo_model');
        $this->load->library('permission');
    }

    public function index() {
        $this->load->view('header');
        $this->load->view('administracion/renovacion/index');
        $this->load->view('footer');
    }
    public function detalle($solicitudid) {
        $data=array(
            'idsolicitud'=>$solicitudid
        );
        $this->load->view('header');
        $this->load->view('administracion/renovacion/detalle',$data);
        $this->load->view('footer');
    }
    

}
