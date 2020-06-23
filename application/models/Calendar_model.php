<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
 
	public function __destruct()
	{
		$this->db->close();
	}
	
	 public function get_events($start, $end,$iduser)
	{
	   // return $this->db->where("start >=", $start)->where("end <=", $end)->get("calendar_events");
		$this->db->select('*');
		$this->db->from('calendar_events');  
		$this->db->where("start >=", $start); 
		$this->db->where("end <=", $end);
		$this->db->where("iduser =", $iduser); 
		$query=$this->db->get();
		return $query->result();
	    
	}

	public function add_event($data)
	{
	    $this->db->insert("calendar_events", $data);
	}

	public function get_event($id)
	{
	    return $this->db->where("ID", $id)->get("calendar_events");
	}

	public function update_event($id, $data)
	{
	    $this->db->where("ID", $id)->update("calendar_events", $data);
	}

	public function delete_event($id)
	{
	    $this->db->where("ID", $id)->delete("calendar_events");
	} 
   
}
