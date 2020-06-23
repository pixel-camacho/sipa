<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cobranza extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		if(!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('login');
        }
        $this->load->helper('url');
		$this->load->model('data_model');
		$this->load->model('amortizacion_model');
		$this->load->model('estadocuenta_model');
		$this->load->library('permission');
		$this->load->library('curl');
	}

	public function index()
	{
		//$result = $this->curl->simple_get('http://201.159.17.216:8484/appsipaapi/solicitudes.php',array('text'=>'bar'));
	  Permission::grant(uri_string());
		 $this->load->view('header');
         $this->load->view('cobranza/index');
         $this->load->view('footer');
	}
	public  function agregarPeriodo()
	{
		  $data    = array(
                'solicitudId' => $this->input->post('id'),
                'fecha' => $this->input->post('fecha'),
                'periodo' => $this->input->post('periodo'),
                'descuento' => $this->input->post('descuento'),
                'pagado' => 1,
                'idUsuario' => $this->session->user_id,
                'status' => 1,
                'fechalocal' => date('Y-m-d H:i:s'),
                'fechasip' => date('Y-m-d H:i:s')
                
            );

        if ($this->amortizacion_model->addPeriodo($data))  {
                $result['error'] = false;
                $result['msg']   = 'User added successfully';
            }
    }

    public function agregarAbono()
    {
    	# code...
    	switch ($this->input->post('contratante')) {
				    case 161:
				       $idMovimientoCargo=9;
				       $idMovimientoAbono=10;
				        break;
				    case 162:
				        $idMovimientoCargo=14;
				        $idMovimientoAbono=15;
				        break;
				    default:
				        $idMovimientoCargo=3;
				        $idMovimientoAbono=4;
				}
	     // $date = DateTime::createFromFormat('d/m/Y', $this->input->post('fechadeposito'));
		 // $fechadeposito=$date->format('Y-m-d');
    	  $datacargo = array(
                'solicitudId' => $this->input->post('id'),
                'cargo' => $this->input->post('cargo'),
                'abono' => 0,
                'fecha' =>$this->input->post('fechadeposito'),
                'periodo' => $this->input->post('periodo'),
                'tipoMovimientoId' =>$idMovimientoCargo,
                'tipoContratoId' => 1,
                'idUsuario' =>  $this->session->user_id,
                'fichaDeposito' =>  $this->input->post('fichadeposito'),
                'opcion' => "insercion",
                'status' => 1,
                'fechalocal' => date('Y-m-d H:i:s'),
                'fechasip' => date('Y-m-d H:i:s')
            );
    	    $dataabono     = array(
                'solicitudId' => $this->input->post('id'),
                'cargo' =>0,
                'abono' => $this->input->post('abono'),
                'fecha' => $this->input->post('fechadeposito'),
                'periodo' => $this->input->post('periodo'),
                'tipoMovimientoId' =>$idMovimientoAbono,
                'tipoContratoId' => 1,
                'idUsuario' =>  $this->session->user_id,
                'fichaDeposito' => $this->input->post('fichadeposito') ,
                'opcion' => "insercion",
                'status' => 1,
                'fechalocal' => date('Y-m-d H:i:s'),
                'fechasip' => date('Y-m-d H:i:s'),
                
            );
			    if ($this->estadocuenta_model->addEstadoCuenta($datacargo));
			    if ($this->estadocuenta_model->addEstadoCuenta($dataabono));
			   // if ($this->estadocuenta_model->addEstadoCuenta($dataabono));
    }
    public function modificarAbono()
    {
        switch ($this->input->post('contratante')) {
                    case 161:
                       $idMovimientoCargo=9;
                       $idMovimientoAbono=10;
                        break;
                    case 162:
                        $idMovimientoCargo=14;
                        $idMovimientoAbono=15;
                        break;
                    default:
                        $idMovimientoCargo=3;
                        $idMovimientoAbono=4;
                }
         $dataabono     = array(
                'solicitudId' => $this->input->post('id'),
                'cargo' =>0,
                'abono' => $this->input->post('abono'),
                'fecha' => $this->input->post('fechadeposito'),
                'periodo' => $this->input->post('periodo'),
                'tipoMovimientoId' =>$idMovimientoAbono,
                'tipoContratoId' => 1,
                'idUsuario' =>  $this->session->user_id,
                'fichaDeposito' => $this->input->post('fichadeposito') ,
                'opcion' => "modificacion",
                'status' => 1,
                'fechalocal' => date('Y-m-d H:i:s'),
                'fechasip' => date('Y-m-d H:i:s'),
                
            ); 
                if ($this->estadocuenta_model->addEstadoCuenta($dataabono));
    }
}
