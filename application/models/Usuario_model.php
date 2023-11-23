<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends CI_model{

    public function __construct()
    {
        parent::__construct();
    }

    public function vehiculos_totales()
    {
        return $this->db->count_all('VEHICULO');
    }

    public function get_vehiculos($limit, $start){
        $this->db->limit($limit, $start);
        $this->db->order_by('VEHICULO.MATRICULA');
        return $this->db->get("VEHICULO")->result_array();
    }

    public function get_usuario($campo, $valor){
        $this->db->where($campo, $valor);
        return $this->db->get("ADMINISTRADOR")->row_array();
    }
}
