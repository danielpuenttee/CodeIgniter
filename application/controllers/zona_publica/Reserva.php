<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model("Usuario_model");

        $this->load->helper("form");
        $this->load->helper('url');
        $this->load->helper('string_helper');

        $this->load->library('table');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->library('session');

        if(!isset($_SESSION)) session_start();
    }

    public function index(int $id_vehiculo, $errores = array('validation_errors' => array('fecha' => '')))
    {
        $vehiculo = $this->Usuario_model->vehiculo_por_id($id_vehiculo);
        if(empty($vehiculo)) http_response_code(404);

        $reservas = $this->Usuario_model->get_reservas($id_vehiculo);
        $empleados_raw = $this->Usuario_model->get_empleados($id_vehiculo);

        $empleados = array('' => '-');
        foreach($empleados_raw as $empleado) {
            $empleados[$empleado['PK_ID_EMPLEADO']] = $empleado['NOMBRE'];
        }

        $data['vehiculo'] = $vehiculo;
        $data['reservas'] = $reservas;
        $data['empleados'] = $empleados;
        $data['validation_errors'] = $errores['validation_errors'];

        $this->load->view('zona_publica/reserva', $data);
    }

    public function guardar()
    {
        $id_vehiculo = (int) $this->input->post('intId');
        $this->form_validation->set_rules('selEmpleado', 'Empleado', "required|trim");
        $this->form_validation->set_rules('dtDesde', 'Desde', 'required');
        $this->form_validation->set_rules('dtHasta', 'Hasta', 'required');

        $desde = strtotime($this->input->post('dtDesde'));
        $hasta = strtotime($this->input->post('dtHasta'));

        $resto_fechas = $this->Usuario_model->get_fechas($id_vehiculo);
        $fecha_valida = $this->chequear_fecha($desde, $hasta, $resto_fechas);

        if($this->form_validation->run()) {
            $id_empleado = (int)$this->input->post('selEmpleado');

            if ($fecha_valida) {
                $this->Usuario_model->guardar_reserva(array(
                    'FK_ID_VEHICULO' => $id_vehiculo,
                    'DESDE' => date('y-m-d H:i:s', $desde),
                    'HASTA' => date('y-m-d H:i:s', $hasta),
                    'FK_ID_EMPLEADO' => $id_empleado,
                    'FK_ESTADO' => 1,
                ));

                header('Location: ../ficha/index/' . $id_vehiculo);
                exit();
            }
        }
        $this->index($id_vehiculo, $this->data);
    }

    public function chequear_fecha($desde, $hasta, $resto_fechas)
    {
        if($desde >= $hasta) {
            $this->data['validation_errors']['fecha'] = "La fecha de inicio no puede ser mayor que la de final";
            return false;
        }
        foreach ($resto_fechas as $intervalo) {
            $otro_desde = strtotime($intervalo['DESDE']);
            $otro_hasta = strtotime($intervalo['HASTA']);

            if (!(($desde >= $otro_hasta) || ($hasta <= $otro_desde))) {
                $this->data['validation_errors']['fecha'] = "Ya hay otra reserva asignada en este intervalo.";
                return false;
            }
        }
        $this->data['validation_errors']['fecha'] = "";
        return true;
    }

}