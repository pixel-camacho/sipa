<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estado_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function __destruct()
    {
        $this->db->close();
    }
    
   public function obtenerEstadoPorCP($cp)
   {
       $this->db->select('e.idestado,e.nombreestado, m.nombremunicipio');
        $this->db->from('tblcolonia c');
        $this->db->join('tblmunicipio m', 'c.idmunicipio=m.idmunicipio');
        $this->db->join('tblestado e', 'm.idestado=e.idestado');  
        $this->db->like('c.cp', $cp); 
        $this->db->group_by('e.nombreestado'); 
        $query = $this->db->get();
        return $query->first_row();
   }
    public function obtenerDatosColoniaDetalle($idcolonia)
   {
        $this->db->select('c.idcolonia,a.nombreasentamiento,c.cp,c.nombrecolonia,m.nombremunicipio,e.nombreestado');
        $this->db->from('tblcolonia c');   
        $this->db->join('tblasentamiento a', 'c.idasentamiento=a.idasentamiento');
        $this->db->join('tblmunicipio m', 'c.idmunicipio=m.idmunicipio');
        $this->db->join('tblestado e', 'm.idestado=e.idestado');
        $this->db->where('c.idcolonia',$idcolonia);
        $query = $this->db->get();
        return $query->first_row();
   }
   public function obtenerEstados()
   {
        $this->db->select('e.idestado,e.nombreestado');
        $this->db->from('tblestado e'); 
        $this->db->order_by("e.nombreestado", "asc");
        $query = $this->db->get();   
        return  $query->result();   
   }
     public function obtenerMunicipios($idestado)
   {
        $this->db->select('m.idmunicipio,m.nombremunicipio');
        $this->db->from('tblmunicipio m');   
        $this->db->where('m.idestado',$idestado);
        $this->db->order_by("m.nombremunicipio", "asc");
        $query = $this->db->get();   
        return  $query->result();   
   }
     public function obtenerColonias($idmunicipio)
   {
        $this->db->select('c.idcolonia,a.nombreasentamiento,c.cp,c.nombrecolonia');
        $this->db->from('tblcolonia c');   
        $this->db->join('tblasentamiento a', 'c.idasentamiento=a.idasentamiento');
        $this->db->where('c.idmunicipio',$idmunicipio);
        $this->db->order_by("c.nombrecolonia", "asc"); 
        $query = $this->db->get();   
        return  $query->result();   
   }
      public function obtenerColoniasPorCP($cp)
   {
        $this->db->select('c.idcolonia,c.cp, c.nombrecolonia');
        $this->db->from('tblcolonia c'); 
        $this->db->where('c.cp',$cp);
        $query = $this->db->get();   
        return  $query->result();   
   }
 
    
}