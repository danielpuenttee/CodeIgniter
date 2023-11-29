<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listado extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model("ZonaPublica_model");

        $this->load->helper("form");
        $this->load->helper('url');
        $this->load->helper('string_helper');

        $this->load->library('table');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->library('session');

        if(!isset($_SESSION)) session_start();
        if(!isset($this->session->PROD_PAGINA))
            $this->session->set_userdata(array('PROD_PAGINA' => VEHICULOS_POR_PAGINA));

        $filtros = array(
            'MARCA' => '',
            'MODELO' => '',
            'MATRICULA' => '',
            'UBICACION' => '',
            'ORDER_BY' => 'MARCA',
            'ORDER_DIR' => 'ASC'
        );
        if(!isset($this->session->FILTROS_PUBLICO)) $this->session->set_userdata(array('FILTROS_PUBLICO' => $filtros));
        if(!isset($this->session->OFFSET)) $this->session->set_userdata(array('OFFSET' => 0));

        $marcas = array('' => '-');
        $marcas = array_merge($marcas, $this->ZonaPublica_model->get_marcas());
        $this->session->MARCAS = $marcas;
    }

    public function index() {
        self::listado();
    }

    public function listado()
    {
        $config = array();
        $config["base_url"] = '/codeigniter/zona_publica/listado/listado';
        $config["total_rows"] = $this->ZonaPublica_model->vehiculos_totales($this->session->FILTROS_PUBLICO);

        $this->session->PROD_PAGINA = (int) ($this->input->post('productos_por_pagina') ?? $this->session->PROD_PAGINA);

        $config["per_page"] = $this->session->PROD_PAGINA;
        $this->pagination->initialize($config);

        if($this->uri->segment(4) === 'volver') {
            if(isset($this->session->OFFSET)) header('Location: /codeigniter/zona_publica/listado/listado/' . $this->session->OFFSET);
            else header('Location: /codeigniter/zona_publica/listado/listado');
        }

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

        $vehiculos = $this->ZonaPublica_model->get_vehiculos($config["per_page"], $offset, $this->session->FILTROS_PUBLICO);
        $existe_foto = false;
        foreach ($vehiculos as $key => &$vehiculo) {
            $vehiculo['MARCA'] = anchor(site_url('zona_publica/ficha/ficha/' . $vehiculo['PK_ID_VEHICULO']), $vehiculo['MARCA']);
            $vehiculo['MODELO'] = anchor(site_url('zona_publica/ficha/ficha/' . $vehiculo['PK_ID_VEHICULO']), $vehiculo['MODELO']);
            $vehiculo['MATRICULA'] = anchor(site_url('zona_publica/ficha/ficha/' . $vehiculo['PK_ID_VEHICULO']), $vehiculo['MATRICULA']);
            $vehiculo['UBICACION'] = anchor(site_url('zona_publica/ficha/ficha/' . $vehiculo['PK_ID_VEHICULO']), $vehiculo['UBICACION']);

            if(!is_null($vehiculo['RENOMBRADO'])) {
                $vehiculo['RENOMBRADO'] = '<img style="max-width:200px; max-height:200px;" src="/codeigniter/imagenes/vehiculos/' . $vehiculo['RENOMBRADO'] . '">';
                $existe_foto = true;
            } else unset($vehiculo['RENOMBRADO']);
            unset($vehiculo['PK_ID_VEHICULO']);
        }
        $data['vehiculos'] = $vehiculos;
        $data['existe_foto'] = $existe_foto;

        $data['filtros'] = $this->session->FILTROS_PUBLICO;
        $data['marcas'] = $this->session->MARCAS;

        $this->load->view('zona_publica/listado', $data);
    }

    public function buscar() {
        $cadenaMarcas = implode(",", $this->session->MARCAS);

        $this->form_validation->set_rules('selMarca', 'Marca', "in_list[$cadenaMarcas]");
        $this->form_validation->set_rules('txModelo', 'Modelo', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('txMatricula', 'Matricula', 'trim|alpha_numeric|max_length[7]');

        if(!$this->form_validation->run()) $this->index();
        else {
            $filtros = $this->session->FILTROS_PUBLICO;
            $filtros['MARCA'] = $this->input->post('selMarca');
            $filtros['MODELO'] = $this->input->post('txModelo');
            $filtros['MATRICULA'] = $this->input->post('txMatricula');
            $filtros['UBICACION'] = $this->input->post('txUbicacion');

            $filtros['ORDER_BY'] = $this->input->post('order_by');
            $filtros['ORDER_DIR'] = $this->input->post('order_dir');
            $this->session->FILTROS_PUBLICO = $filtros;

            $this->listado();
        }
    }

    public function resetear() {
        $this->session->FILTROS_PUBLICO = array(
            'MARCA' => '',
            'MODELO' => '',
            'MATRICULA' => '',
            'UBICACION' => '',
            'ORDER_BY' => 'MARCA',
            'ORDER_DIR' => 'ASC'
        );
        $this->listado();
    }
}
