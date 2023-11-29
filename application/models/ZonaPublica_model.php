<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class ZonaPublica_model extends CI_model{

    public function __construct()
    {
        parent::__construct();
    }

    public function vehiculos_totales($filtros)
    {
        $this->db->from('VEHICULO');

        $this->db->like('MARCA', $filtros['MARCA']);
        $this->db->like('MODELO', $filtros['MODELO']);
        $this->db->like('MATRICULA', $filtros['MATRICULA']);

        return $this->db->count_all_results();
    }

    public function get_vehiculos($limit, $start, $filtros){
        $this->db->join('FOTO', 'FOTO.FK_ID_VEHICULO = VEHICULO.PK_ID_VEHICULO', 'left');

        $this->db->like('MARCA', $filtros['MARCA']);
        $this->db->like('MODELO', $filtros['MODELO']);
        $this->db->like('MATRICULA', $filtros['MATRICULA']);
        $this->db->like('UBICACION', $filtros['UBICACION']);

        $this->db->limit($limit, $start);
        $this->db->order_by($filtros['ORDER_BY'], $filtros['ORDER_DIR']);

        $this->db->select('VEHICULO.*, FOTO.RENOMBRADO');
        return $this->db->get("VEHICULO")->result_array();
    }

    public function vehiculo_por_id(int $id_producto)
    {
        $this->db->join('FOTO', 'FOTO.FK_ID_VEHICULO = VEHICULO.PK_ID_VEHICULO', 'left');
        $this->db->where('VEHICULO.PK_ID_VEHICULO', $id_producto);
        $this->db->select('VEHICULO.*, FOTO.RENOMBRADO');
        return $this->db->get('VEHICULO')->row_array();
    }

    public function get_administrador($campo, $valor){
        $this->db->where($campo, $valor);
        return $this->db->get("ADMINISTRADOR")->row_array();
    }

    public function get_marcas(){
        $this->db->distinct();
        $this->db->select('MARCA');
        $array = $this->db->get('VEHICULO')->result_array();

        $formateado = array();
        foreach($array as $valor) {
            $formateado[$valor['MARCA']] = $valor['MARCA'];
        }
        return $formateado;
    }

    public function get_reservas(int $id_vehiculo)
    {
        $this->db->join('ESTADO', 'RESERVA.FK_ESTADO = ESTADO.PK_ID_ESTADO');
        $this->db->join('EMPLEADO', 'RESERVA.FK_ID_EMPLEADO = EMPLEADO.PK_ID_EMPLEADO');
        $this->db->select('RESERVA.DESDE, RESERVA.HASTA, CONCAT(EMPLEADO.NOMBRE," ",EMPLEADO.APELLIDOS), ESTADO.ESTADO');

        $this->db->where('FK_ID_VEHICULO', $id_vehiculo);
        $this->db->order_by('DESDE');
        return $this->db->get("RESERVA")->result_array();
    }

    public function guardar_reserva(array $reserva)
    {
        $this->db->insert('RESERVA', $reserva);
    }

    public function get_empleados()
    {
        $this->db->select('PK_ID_EMPLEADO, CONCAT(NOMBRE, " ", APELLIDOS) AS NOMBRE');
        return $this->db->get("EMPLEADO")->result_array();
    }

    public function get_fechas($id_vehiculo)
    {
        $this->db->select('DESDE, HASTA');
        $this->db->where('FK_ID_VEHICULO', $id_vehiculo);
        return $this->db->get("RESERVA")->result_array();
    }
}
