 <?php
class User_model extends CI_Model
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
        $this->db->select('u.*,r.id as idrol, r.rol as rolnombre');    
        $this->db->from('users u');
        $this->db->join('users_rol ur', 'u.id = ur.id_user');
        $this->db->join('rol r', 'ur.id_rol = r.id'); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
 

    public function addUser($data)
    {
        $this->db->insert('users', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    
    
    public function updateUser($id, $field)
    {
        $this->db->where('id', $id);
        $this->db->update('users', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
      public function updateUserRol($id, $field)
    {
        $this->db->where('id_user', $id);
        $this->db->update('users_rol', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
      public function passwordupdateUser($id, $field)
    {
        $this->db->where('id', $id);
        $this->db->update('users', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
    public function deleteUser($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
    public function searchUser($match)
    {
        $field = array(
            'u.usuario',
            'u.name'
        );
        $this->db->select('u.*,r.id as idrol, r.rol as rolnombre');    
        $this->db->from('users u');
        $this->db->join('users_rol ur', 'u.id = ur.id_user');
        $this->db->join('rol r', 'ur.id_rol = r.id'); 
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get(); 
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
     public function addUserRol($data)
    {
        return $this->db->insert('users_rol', $data);
    }  
      public function detalleUsuario($id) {
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->where('u.id', $id);
        $query = $this->db->get();
        return $query->first_row();
    }
}
?> 