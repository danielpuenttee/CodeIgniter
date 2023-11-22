<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Administrador_Controller extends MY_Controller
{
	protected $data;
	protected $administrador;

	function __construct()
	{
		parent::__construct();

		// Cargo librerías comunes necesarias en la zona privada
		$this->load->library('session');
		$this->load->helper('string');
		$this->load->helper('language');
		$this->load->model('Administrador_model');
		$this->load->helper('date');
		$this->load->library('table');
		$this->load->library('pagination');
		$this->load->helper('form');
		$this->load->helper('url');

		// Establezco valores iniciales por defecto
		$this->data = array();
		$this->data['administrador'] = $this->administrador;

		// Obtengo los datos de sesión del flashdata POST.
		// Dichos datos estarán disponibles para la siguiente solicitud y luego se borran automáticamente.
		if ($this->session->flashdata('_POST') !== FALSE && count($_POST) === 0) {
			$_POST = $this->session->flashdata('_POST');
		}

		// Genero una nueva sesion en caso de no
		if (!isset($_SESSION)) {
			session_start();
		}

		// Cargo el administrador de sesion si existe
		$this->administrador = $this->session->userdata("administrador");
		$this->data['administrador'] = &$this->administrador;

		// Si no está logueado lo redirijo al login
		// Compruebo que la página sea distinta del login. Problema: redirecciones infinitas.
		// Si está logueado, obtengo de nuevo los datos del administrador
		if (!$this->administrador) {
			if (uri_string() != RUTA_ADMINISTRACION.'/administrador/login') {
				header("Location:".site_url(RUTA_ADMINISTRACION . '/administrador/login'));
				exit;
			}
		} else if ($this->administrador && isset($this->administrador['PK_ID_ADMINISTRADOR'])) {
			$this->administrador = $this->Administrador_model->get($this->administrador['PK_ID_ADMINISTRADOR']);
			$this->data['administrador'] = &$this->administrador;
		}
	}
}
