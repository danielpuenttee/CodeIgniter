<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends Administrador_Controller
{
	public function index()
	{
        $this->session->unset_userdata('FILTROS_PRIVADO');
        $this->session->unset_userdata('FILTROS_EMPLEADOS');
        $this->session->unset_userdata('FILTROS_RESERVAS');
        $this->load->view('administracion/bienvenida', $this->data);
	}
}
