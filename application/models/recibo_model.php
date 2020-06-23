<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recibo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

    public function addReciboProvicional($data) {
        $this->db->insert('tblrecibos', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
        public function addDetalleRecibo($data) {
        $this->db->insert('tblformapagorecibo', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function showAllRecibosPorUsuario($idusuario) {
        $this->db->select("r.*,  DATE_FORMAT(r.fecharegistro,'%d/%m/%Y') AS fechare");
        $this->db->from('tblrecibos r');
        $this->db->where('r.idusuario', $idusuario);
        $this->db->order_by("r.fecharegistro", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function detalleRecibo($id) {
        $this->db->select("r.idcliente, r.poliza, r.cantidad, DATE_FORMAT(r.fechainicio,'%d/%m/%Y') AS fechainicio, DATE_FORMAT(r.fechafin,'%d/%m/%Y') AS fechafin, r.periodocobro, DATE_FORMAT(r.fecharegistro,'%d/%m/%Y') AS fecha, r.idproducto, r.idcompania");
        $this->db->from('tblrecibos r');
        $this->db->where('r.idrecibo', $id);
        $query = $this->db->get();
        return $query->first_row();
    }
    public function obtenerFormaPago($idrecibo) {
         $this->db->select('r.idtipo, r.autorizacion');
        $this->db->from('tblformapagorecibo r');
        $this->db->where('r.idrecibo', $idrecibo);
        $query = $this->db->get();
        return $query->first_row();
    }
}
