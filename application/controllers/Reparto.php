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

	public function repartoFile(){
		
	   $documento = $_FILES['input-text']['name'];
	   $destinatario = $this->input->get_post("destinatario");
	   $extension = pathinfo($documento, PATHINFO_EXTENSION);
       $nombre = pathinfo($documento, PATHINFO_FILENAME);
       $repartidor = $this->session->idusuario;

       $extensionesPermitidas = array("pdf","PDF");

       if(! in_array($extension,$extensionesPermitidas)) 
         {
            echo (json_encode(array('status'=>'wrongFile')));
            return; 
         }

        $ruta = base_url("assets/Archivos/").$nombre;

        $config['upload_path'] = './assets/Archivos/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 0;
        $config['file_name'] = $nombre;

        $this->load->library('upload',$config);

        $arrayDocumen = ['documento' => $nombre,
                         'destinatario' => $destinatario];

        

        

   }
	
}