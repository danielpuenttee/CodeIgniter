<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ficha extends CI_Controller {

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
    }

    public function index(int $id_vehiculo = NULL) {
        self::ficha($id_vehiculo);
    }

    public function ficha(int $id_vehiculo = NULL)
    {
        if(is_null($id_vehiculo)) {
            http_response_code(404);
            exit;
        }

        $vehiculo = $this->ZonaPublica_model->vehiculo_por_id($id_vehiculo);
        if(empty($vehiculo)) http_response_code(404);

        $reservas = $this->ZonaPublica_model->get_reservas($id_vehiculo);

        $data['vehiculo'] = $vehiculo;
        $data['reservas'] = $reservas;
        $this->load->view('zona_publica/ficha', $data);
    }
}