<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class ZonaPrivada_model extends CI_model{

    public function __construct()
    {
        parent::__construct();
    }

    public function empleados_totales($filtros)
    {
        $this->db->from('EMPLEADO');

        $this->db->like('IDENTIFICADOR', $filtros['IDENTIFICADOR']);
        $this->db->like('NOMBRE', $filtros['NOMBRE']);
        $this->db->like('APELLIDOS', $filtros['APELLIDOS']);

        if(!empty($filtros['FECHA_NACIMIENTO'])) $this->db->where('YEAR(EMPLEADO.FECHA_NACIMIENTO)', $filtros['FECHA_NACIMIENTO']);

        return $this->db->count_all_results();
    }

    public function get_empleados($limit, $start, $filtros){
        $this->db->like('IDENTIFICADOR', $filtros['IDENTIFICADOR']);
        $this->db->like('NOMBRE', $filtros['NOMBRE']);
        $this->db->like('APELLIDOS', $filtros['APELLIDOS']);

        if(!empty($filtros['FECHA_NACIMIENTO'])) $this->db->where('YEAR(EMPLEADO.FECHA_NACIMIENTO)', $filtros['FECHA_NACIMIENTO']);

        $this->db->limit($limit, $start);
        $this->db->order_by($filtros['ORDER_BY'], $filtros['ORDER_DIR']);

        return $this->db->get("EMPLEADO")->result_array();
    }

    public function empleado_por_id(int $id_empleado)
    {
        $this->db->where('EMPLEADO.PK_ID_EMPLEADO', $id_empleado);
        return $this->db->get('EMPLEADO')->row_array();
    }

    public function get_estados(){
        $this->db->distinct();
        $this->db->select('ESTADO');
        $array = $this->db->get('ESTADO')->result_array();

        $formateado = array();
        foreach($array as $valor) {
            $formateado[$valor['ESTADO']] = $valor['ESTADO'];
        }
        return $formateado;
    }

    public function insertar_modificar_empleado(int $id_empleado, array $empleado)
    {
        if ($id_empleado === 0) {
            $this->db->insert('EMPLEADO', $empleado);
        } else {
            // Si el pedido ya existe, actualiza los valores
            $this->db->where('PK_ID_EMPLEADO', $id_empleado);
            $this->db->update('EMPLEADO', $empleado);
        }
    }


    public function existe_vehiculo(int $id_vehiculo) {
        $this->db->where('PK_ID_VEHICULO', $id_vehiculo);
        $query = $this->db->get('VEHICULO');

        return $query->num_rows() > 0;
    }

    public function existe_foto($id_vehiculo = NULL)
    {
        if(!is_null($id_vehiculo)) $this->db->where('FK_ID_VEHICULO', $id_vehiculo);
        $query = $this->db->get('FOTO');

        return $query->num_rows() > 0;
    }

    public function insertar_modificar_vehiculo(int $id_vehiculo, array $vehiculo)
    {
        if ($id_vehiculo === 0): $this->db->insert('VEHICULO', $vehiculo);
        else:
            $this->db->where('PK_ID_VEHICULO', $id_vehiculo);
            $this->db->update('VEHICULO', $vehiculo);
        endif;
    }

    public function insertar_modificar_foto(array $foto)
    {
        $this->db->where('FK_ID_VEHICULO', $foto['FK_ID_VEHICULO']);
        $query = $this->db->get('FOTO');

        if ($query->num_rows() > 0) {
            $this->db->where('FK_ID_VEHICULO', $foto['FK_ID_VEHICULO']);
            $this->db->update('FOTO', $foto);
        }
        else $this->db->insert('FOTO', $foto);
    }

    public function reservas_totales(array $filtros)
    {
        $this->db->from('RESERVA');

        $this->db->like('VEHICULO.MARCA', $filtros['MARCA']);
        $this->db->like('VEHICULO.MODELO', $filtros['MODELO']);
        $this->db->like('VEHICULO.MATRICULA', $filtros['MATRICULA']);
        $this->db->like('VEHICULO.UBICACION', $filtros['UBICACION']);
        $this->db->like("CONCAT(EMPLEADO.NOMBRE, ' ', EMPLEADO.APELLIDOS)", $filtros['EMPLEADO']);
        $this->db->like('ESTADO.ESTADO', $filtros['ESTADO']);

        if(!empty($filtros['DESDE'])) {
            $this->db->where("RESERVA.DESDE>=", $filtros['DESDE']);
        }
        if(!empty($filtros['HASTA'])) {
            $this->db->where("RESERVA.HASTA<=", $filtros['HASTA']);
        }

        $this->db->join('VEHICULO', 'RESERVA.FK_ID_VEHICULO = VEHICULO.PK_ID_VEHICULO');
        $this->db->join('EMPLEADO', 'RESERVA.FK_ID_EMPLEADO = EMPLEADO.PK_ID_EMPLEADO');
        $this->db->join('ESTADO', 'RESERVA.FK_ESTADO = ESTADO.PK_ID_ESTADO');

        return $this->db->count_all_results();
    }

    public function get_reservas_extended(int $limit, int $start, array $filtros){
        $this->db->join('VEHICULO', 'RESERVA.FK_ID_VEHICULO = VEHICULO.PK_ID_VEHICULO');
        $this->db->join('EMPLEADO', 'RESERVA.FK_ID_EMPLEADO = EMPLEADO.PK_ID_EMPLEADO');
        $this->db->join('ESTADO', 'RESERVA.FK_ESTADO = ESTADO.PK_ID_ESTADO');

        $this->db->like('VEHICULO.MARCA', $filtros['MARCA']);
        $this->db->like('VEHICULO.MODELO', $filtros['MODELO']);
        $this->db->like('VEHICULO.MATRICULA', $filtros['MATRICULA']);
        $this->db->like('VEHICULO.UBICACION', $filtros['UBICACION']);
        $this->db->like("CONCAT(EMPLEADO.NOMBRE, ' ', EMPLEADO.APELLIDOS)", $filtros['EMPLEADO']);
        $this->db->like('ESTADO.ESTADO', $filtros['ESTADO']);

        if(!empty($filtros['DESDE'])) $this->db->where("RESERVA.DESDE>=", $filtros['DESDE']);
        if(!empty($filtros['HASTA'])) $this->db->where("RESERVA.HASTA<=", $filtros['HASTA']);


        $this->db->select("
            RESERVA.PK_ID_RESERVA,
            VEHICULO.MARCA, VEHICULO.MODELO, VEHICULO.MATRICULA, VEHICULO.UBICACION, 
            CONCAT(EMPLEADO.NOMBRE, ' ', EMPLEADO.APELLIDOS) AS EMPLEADO, 
            RESERVA.DESDE, RESERVA.HASTA, 
            ESTADO.ESTADO");

        $this->db->limit($limit, $start);
        $this->db->order_by($filtros['ORDER_BY'], $filtros['ORDER_DIR']);

        return $this->db->get('RESERVA')->result_array();
    }


    public function get_reservas_botones(int $id_vehiculo){
        $this->db->join('VEHICULO', 'RESERVA.FK_ID_VEHICULO = VEHICULO.PK_ID_VEHICULO');
        $this->db->join('EMPLEADO', 'RESERVA.FK_ID_EMPLEADO = EMPLEADO.PK_ID_EMPLEADO');
        $this->db->join('ESTADO', 'RESERVA.FK_ESTADO = ESTADO.PK_ID_ESTADO');

        $this->db->where('VEHICULO.PK_ID_VEHICULO', $id_vehiculo);

        $this->db->select("
            RESERVA.PK_ID_RESERVA,
            RESERVA.DESDE, RESERVA.HASTA, 
            CONCAT(EMPLEADO.NOMBRE, ' ', EMPLEADO.APELLIDOS) AS EMPLEADO, 
            ESTADO.ESTADO");

        $this->db->order_by('RESERVA.DESDE', 'ASC');

        return $this->db->get('RESERVA')->result_array();
    }


    public function modificar_estado_reserva(int $id_reserva, int $estado){
        $this->db->set('FK_ESTADO', $estado);
        $this->db->where('PK_ID_RESERVA', $id_reserva);
        $this->db->update('RESERVA');
    }
}