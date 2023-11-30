<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservas extends Administrador_Controller {

    public function __construct()
    {
        parent::__construct();

        if(!isset($_SESSION)) session_start();
        if(!isset($this->session->PROD_PAGINA))
            $this->session->set_userdata(array('PROD_PAGINA' => VEHICULOS_POR_PAGINA));


        $filtros = array(
            'MARCA' => '',
            'MODELO' => '',
            'MATRICULA' => '',
            'UBICACION' => '',
            'EMPLEADO' => '',
            'DESDE' => '',
            'HASTA' => '',
            'ESTADO' => '',
            'ORDER_BY' => 'MATRICULA',
            'ORDER_DIR' => 'ASC'
        );
        if(!isset($this->session->FILTROS_RESERVAS)) $this->session->set_userdata(array('FILTROS_RESERVAS' => $filtros));
        if(!isset($this->session->OFFSET)) $this->session->set_userdata(array('OFFSET' => 0));
    }

    public function index()
    {
        self::listado();
    }

    public function listado($errores = array('validation_errors' => array('fecha' => '')))
    {
        $config = array();
        $config["base_url"] = '/codeigniter/' . RUTA_ADMINISTRACION . '/reservas/listado';
        $config["total_rows"] = $this->ZonaPrivada_model->reservas_totales($this->session->FILTROS_RESERVAS);

        $this->session->PROD_PAGINA = (int) ($this->input->post('productos_por_pagina') ?? $this->session->PROD_PAGINA);

        $config["per_page"] = $this->session->PROD_PAGINA;
        $this->pagination->initialize($config);

        $offset = ($this->uri->segment(4)) ? (int) $this->uri->segment(4) : 0;
        $pagina = $offset / $config["per_page"] + 1;
        $this->session->OFFSET = $offset;

        $total_paginas = (int)ceil($config["total_rows"] / $config["per_page"]);

        $data['paginacion'] = array(
            "LIMIT" => $config["per_page"],
            "OFFSET" => $offset,
            "PAGINA" => $pagina,
            "OFFSET_PAGINA" => $pagina !== 0 ? ($pagina - 1) * $config["per_page"] : 0,
            "TOTAL" => (int) $config["total_rows"],
            "TOTAL_PAGINAS" => $total_paginas
        );

        $filtros = $this->session->FILTROS_RESERVAS;
        $headers = array(
            '<span onclick="ordenar(\'MARCA\')"> Marca' . ($filtros['ORDER_BY'] === 'MARCA' ? $filtros['ORDER_DIR'] === 'ASC' ? '&#8593' : '&#8595' : '&#8593&#8595') . '</span>',
            '<span onclick="ordenar(\'MODELO\')"> Modelo' . ($filtros['ORDER_BY'] === 'MODELO' ? $filtros['ORDER_DIR'] === 'ASC' ? '&#8593' : '&#8595' : '&#8593&#8595') . '</span>',
            '<span onclick="ordenar(\'MATRICULA\')"> Matricula' . ($filtros['ORDER_BY'] === 'MATRICULA' ? $filtros['ORDER_DIR'] === 'ASC' ? '&#8593' : '&#8595' : '&#8593&#8595') . '</span>',
            'Ubicacion',
            '<span onclick="ordenar(\'EMPLEADO\')"> Empleado' . ($filtros['ORDER_BY'] === 'EMPLEADO' ? $filtros['ORDER_DIR'] === 'ASC' ? '&#8593' : '&#8595' : '&#8593&#8595') . '</span>',
            '<span onclick="ordenar(\'DESDE\')"> Desde' . ($filtros['ORDER_BY'] === 'DESDE' ? $filtros['ORDER_DIR'] === 'ASC' ? '&#8593' : '&#8595' : '&#8593&#8595') . '</span>',
            '<span onclick="ordenar(\'HASTA\')"> Hasta' . ($filtros['ORDER_BY'] === 'HASTA' ? $filtros['ORDER_DIR'] === 'ASC' ? '&#8593' : '&#8595' : '&#8593&#8595') . '</span>',
            '<span onclick="ordenar(\'ESTADO\')"> Estado' . ($filtros['ORDER_BY'] === 'ESTADO' ? $filtros['ORDER_DIR'] === 'ASC' ? '&#8593' : '&#8595' : '&#8593&#8595') . '</span>'
        );


        $reservas = $this->ZonaPrivada_model->get_reservas_extended($config["per_page"], $offset, $this->session->FILTROS_RESERVAS);
        foreach ($reservas as $key => &$reserva) {
            if($reserva['ESTADO'] === 'Pte. de Aceptar')
                $reserva['BOTONES'] =
                    '<button 
                        type="button" 
                        onclick="window.location.href=\'' . site_url(RUTA_ADMINISTRACION . '/reservas/aceptar/' . $reserva['PK_ID_RESERVA']) . '\'">
                            Aceptar
                    </button>'
                    . ' ' .
                    '<button 
                        type="button" 
                        onclick="window.location.href=\'' . site_url(RUTA_ADMINISTRACION . '/reservas/denegar/' . $reserva['PK_ID_RESERVA']) . '\'">
                            Denegar
                    </button>';
            unset($reserva['PK_ID_RESERVA']);
        }

        $data['headers'] = $headers;
        $data['reservas'] = $reservas;

        $data['filtros'] = $this->session->FILTROS_RESERVAS;
        $data['marcas'] = $this->session->MARCAS;
        $data['estados'] = array_merge(array('' => '-'), $this->ZonaPrivada_model->get_estados());
        $data['validation_errors'] = $errores;

        $this->load->view('administracion/reservas/listado', $data);
    }

    public function aceptar(int $id_reserva, $ficha_vehiculo = 0) {
        $this->ZonaPrivada_model->modificar_estado_reserva($id_reserva, 2);

        if($ficha_vehiculo === 0) header("Location:".site_url(RUTA_ADMINISTRACION . '/reservas/listado'));
        else header("Location:".site_url(RUTA_ADMINISTRACION . '/vehiculos/ficha/' . $ficha_vehiculo));
    }

    public function denegar(int $id_reserva, $ficha_vehiculo = 0) {
        $this->ZonaPrivada_model->modificar_estado_reserva($id_reserva, 3);

        if($ficha_vehiculo === 0) header("Location:".site_url(RUTA_ADMINISTRACION . '/reservas/listado'));
        else header("Location:".site_url(RUTA_ADMINISTRACION . '/vehiculos/ficha/' . $ficha_vehiculo));
    }

    public function buscar() {
        $cadenaMarcas = implode(",", $this->session->MARCAS);

        $this->form_validation->set_rules('selMarca', 'Marca', "in_list[$cadenaMarcas]");
        $this->form_validation->set_rules('txModelo', 'Modelo', 'trim|alpha_numeric_spaces');
        $this->form_validation->set_rules('txMatricula', 'Matricula', 'trim|alpha_numeric|max_length[7]');
        $this->form_validation->set_rules('txUbicacion', 'Ubicacion', 'trim');
        $this->form_validation->set_rules('txEmpleado', 'Ubicacion', 'trim|alpha_numeric_spaces');
        $this->form_validation->set_rules('selEstado', 'Estado', 'trim');

        $this->form_validation->set_rules('dtDesde', 'Desde', 'trim|callback_fecha_valida');
        $this->form_validation->set_message('fecha_valida', 'El campo {field} no tiene un formato válido.');

        $this->form_validation->set_rules('dtHasta', 'Hasta', 'trim|callback_fecha_valida');
        $this->form_validation->set_message('fecha_valida', 'El campo {field} no tiene un formato válido.');

        $desde = strtotime($this->input->post('dtDesde'));
        $hasta = strtotime($this->input->post('dtHasta'));

        $correcto = true;
        $this->data['validation_errors']['fecha'] = '';
        if($desde !== false && $hasta !== false && $desde > $hasta) {
            $correcto = false;
            $this->data['validation_errors']['fecha'] = "La fecha de inicio no puede ser mayor que la de final";
        }

        if(!$this->form_validation->run()) {
            $this->listado();
        }
        if(!$correcto){
            $this->form_validation->set_value('dtDesde', $this->input->post('dtDesde'));
            $this->form_validation->set_value('dtHasta', $this->input->post('dtHasta'));

            $this->listado($this->data['validation_errors']);
        }
        else {
            $filtros = $this->session->FILTROS_RESERVAS;
            $filtros['MARCA'] = $this->input->post('selMarca');
            $filtros['MODELO'] = $this->input->post('txModelo');
            $filtros['MATRICULA'] = $this->input->post('txMatricula');
            $filtros['UBICACION'] = $this->input->post('txUbicacion');
            $filtros['EMPLEADO'] = $this->input->post('txEmpleado');
            $filtros['ESTADO'] = $this->input->post('selEstado');
            $filtros['DESDE'] = $this->input->post('dtDesde');
            $filtros['HASTA'] = $this->input->post('dtHasta');

            $filtros['ORDER_BY'] = $this->input->post('order_by');
            $filtros['ORDER_DIR'] = $this->input->post('order_dir');
            $this->session->FILTROS_RESERVAS = $filtros;

            $this->index();
        }
    }

    public function resetear() {
        $this->session->FILTROS_RESERVAS = array(
            'MARCA' => '',
            'MODELO' => '',
            'MATRICULA' => '',
            'UBICACION' => '',
            'EMPLEADO' => '',
            'ESTADO' => '',
            'DESDE' => '',
            'HASTA' => '',
            'ORDER_BY' => 'PK_ID_RESERVA',
            'ORDER_DIR' => 'ASC'
        );
        $this->session->PROD_PAGINA = VEHICULOS_POR_PAGINA;

        $this->listado();
    }

    public function fecha_valida($fecha)
    {
        return empty($fecha) || strtotime($fecha) !== false;
    }
}