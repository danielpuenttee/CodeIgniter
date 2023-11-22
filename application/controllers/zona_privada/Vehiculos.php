<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculos extends Administrador_Controller
{
	public function index()
	{
		self::listado();
	}

    public function listado(){
        $this->load->view('administracion/vehiculos/listado', $this->data);
    }
}
