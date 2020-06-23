 <?php
class Colonia_model extends CI_Model
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
    
    
    public function showAll()
    {
         $this->db->select('c.idcolonia,c.cp, c.nombrecolonia');
        $this->db->from('tblcolonia c');
        $this->db->join('tblmunicipio m', 'c.idmunicipio=m.idmunicipio');
        $this->db->join('tblestado e', 'm.idestado=e.idestado');  
        $this->db->where('e.idestado',2);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
 
 
}
?> 