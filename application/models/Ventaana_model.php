<?php

class Ventaana_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db2 = $this->load->database('second', TRUE);
    }

    public function __destruct() {
        $this->db2->close();
    }

    public function addVenta($data) {
        $this->db2->insert('tblventaana', $data);
        $insert_id = $this->db2->insert_id();
        return $insert_id;
    }

}

?> 