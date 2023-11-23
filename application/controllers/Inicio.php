<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

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
        $this->session->set_userdata(array('PROD_PAGINA' => 1));
        $this->session->set_userdata(array('FILTROS' => array(
            'MARCA' => '',
            'MODELO' => '',
            'MATRICULA' => ''
        )));
    }

    public function index()
    {
        if(is_null($this->input->post('productos_por_pagina'))) $this->session->PROD_PAGINA = 1;

        $config = array();
        $config["base_url"] = '/codeigniter/inicio/index';
        $config["total_rows"] = $this->Usuario_model->vehiculos_totales();

        $this->session->PROD_PAGINA = (int) ($this->input->post('productos_por_pagina') ?? $this->session->PROD_PAGINA);

        $config["per_page"] = $this->session->PROD_PAGINA;
        $this->pagination->initialize($config);

        if($this->uri->segment(3) === 'cancelar') {
            if(isset($this->session->PAGINA)) header('Location: /codeigniter/inicio/index' . $this->session->PAGINA);
            else header('Location: /codeigniter/inicio/index');
        }

        $offset = ($this->uri->segment(3)) ? (int) $this->uri->segment(3) : 0;
        $pagina = $offset / $config["per_page"] + 1;

        $this->session->set_userdata(array('PAGINA' => $offset));
        $total_paginas = (int)ceil($config["total_rows"] / $config["per_page"]);

        $data['paginacion'] = array(
            "LIMIT" => $config["per_page"],
            "OFFSET" => $offset,
            "PAGINA" => $pagina,
            "OFFSET_PAGINA" => $pagina !== 0 ? ($pagina - 1) * $config["per_page"] : 0,
            "TOTAL" => (int) $config["total_rows"],
            "TOTAL_PAGINAS" => $total_paginas
        );

        $vehiculos = $this->Usuario_model->get_vehiculos($config["per_page"], $offset);
        foreach ($vehiculos as $key => &$vehiculo) {
            $vehiculo['MARCA'] = anchor(site_url('../productos/ficha/' . $vehiculo['PK_ID_VEHICULO']), $vehiculo['MARCA']);
            $vehiculo['MODELO'] = anchor(site_url('../productos/ficha/' . $vehiculo['PK_ID_VEHICULO']), $vehiculo['MODELO']);
            $vehiculo['MATRICULA'] = anchor(site_url('../productos/ficha/' . $vehiculo['PK_ID_VEHICULO']), $vehiculo['MATRICULA']);
            $vehiculo['UBICACION'] = anchor(site_url('../productos/ficha/' . $vehiculo['PK_ID_VEHICULO']), $vehiculo['UBICACION']);

            unset($vehiculo['PK_ID_VEHICULO']);
        }

        $data['vehiculos'] = $vehiculos;

        $this->load->view('inicio', $data);
    }
}
