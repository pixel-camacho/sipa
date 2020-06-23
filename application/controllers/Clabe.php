<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Load libruary for API
class Clabe extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		if(!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('login');
        }
        $this->load->helper('url');
    		$this->load->model('data_model');
        $this->load->model('clabe_model'); 
    		$this->load->library('permission'); 
	}

	public function index()
	{
          Permission::grant(uri_string());
		       $this->load->view('header');
           $this->load->view('clabe/index');
           $this->load->view('footer');
	}
  public  function agregarClabe()
  {
      $data    = array(
                'idsolicitud ' => $this->input->post('id'),
                'idbanco' => $this->input->post('banco'),
                'idtipotarjeta' => $this->input->post('tipotarjeta'),
                'numero' => $this->input->post('tarjeta'),
                'titular' => $this->input->post('titular'),
                'tipo' => "D",
                'idusuario' =>  $this->session->user_id,
                'fecha' => date('Y-m-d H:i:s')
                
            );

        if ($this->clabe_model->addClabe($data))  {
                $result['error'] = false;
                $result['msg']   = 'User added successfully';
            }
    }
}
