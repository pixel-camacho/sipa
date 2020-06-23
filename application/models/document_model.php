 <?php
 class Document_model extends CI_Model
 {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /**
     * Funcion para subir archivos documentos
    **/
    public function uploadDocument($arrayDocument)
    {
        $this->db->insert("documento",$arrayDocument);

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }


    /**
     * Funcion para obtener la informacion del cliente por su [id]
    **/
    public function infoCliente($id)
    {
        $this->db->select('*');    
        $this->db->from('cliente');
        $this->db->where('IdCliente',$id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    /**
     * Funcion para obtener la informacion del documento en funcion del [id] del cliente
    **/
    public function infoDocumento($id)
    {
        $this->db->select('documento.Idcliente, documento.pathImg as nombre_doc,categoria.descripcion as tipo_documento, producto.descripcion as tipo_producto');    
        $this->db->from('documento as documento');
        $this->db->join('cat_documento AS categoria','documento.iddocumento = categoria.iddocumento');
        $this->db->join('cat_producto AS producto','documento.idproducto = producto.idproducto');
        $this->db->where('documento.IdCliente',$id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * Funcion para buscar los clientes
    **/
    public function searchUser($match)
    {
        //$sub_query = "(SELECT *, CONCAT(nombre, ' ', apellido1, ' ',apellido2) nombre_completo FROM cliente ) base";

        $this->db->select("c.*");
        // Agregar subquery    
        $this->db->from("cliente c");
        // Encontrar coincidencias al buscar
        //$this->db->like('nombre_completo',$match);
        $this->db->where("CONCAT(c.nombre,' ',c.apellido1,' ',c.apellido2) LIKE '%".$match."%'", NULL, FALSE);
        // Encontrar coincidencia exacta
        // $this->db->where('nombre_completo',$match);
        $query = $this->db->get(); 
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }


      /*$field = array(
            'u.usuario',
            'u.name'
        );
        $this->db->select('c.*,CONCAT(c.nombre, ' ', c.apellido1, ' ',c.apellido2) nombre_completo');    
        $this->db->from('cliente '); 
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get(); 
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }*/

    }
    /**
     * Funcion para obtener los tipos de documentos 
    **/
    public function getTipoDocumento()
    {
        $this->db->select('*');
        $this->db->from('cat_documento');
        $query = $this->db->get();
        
        return $query->result();
    }
    /**
     * Funcion para obtener los tipos de productos 
    **/
    public function getTipoProducto()
    {
        $this->db->select('*');
        $this->db->from('cat_producto');
        $query = $this->db->get();
        
        return $query->result();
    }
    /**
     * Funcion para forzar la descarga de documentos
    **/
    public function download($params = array())
    {
        $this->db->select('*');    
        $this->db->from('documento');
        $this->db->where('pathImg',$params['nombre_doc']);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    /**
     * Funcion para crear un nuevo cliente 
    **/
    public function createClient($arrayClient)
    {
        $this->db->insert("cliente",$arrayClient);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}
?> 