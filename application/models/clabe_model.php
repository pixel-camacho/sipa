<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clabe_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
 
	public function __destruct()
	{
		$this->db->close();
	}
	
  public function addClabe($data)
    {
        return $this->db->insert('tbltarjeta', $data);
    }  
   
}
