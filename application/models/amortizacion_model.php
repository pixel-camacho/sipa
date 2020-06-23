<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Amortizacion_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
 
	public function __destruct()
	{
		$this->db->close();
	}
	
    
     public function addPeriodo($data)
    {
        return $this->db->insert('tablaamortizacioncliente', $data);
    }  
    
   
  }
