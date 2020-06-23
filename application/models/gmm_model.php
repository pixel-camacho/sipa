<?php
class gmm_model extends CI_Model
{
	
     public	function __construct()
	{
		parent::__construct();
		$this->load->db();
	}

    public	function __destruct()
	{
       $this->db->close();
	}

	



}