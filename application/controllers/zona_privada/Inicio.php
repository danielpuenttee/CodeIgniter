<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends Administrador_Controller
{
	public function index()
	{
		$this->load->view('administracion/bienvenida', $this->data);
	}
}
