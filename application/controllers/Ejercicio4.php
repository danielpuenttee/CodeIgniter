<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ejercicio4 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		//		El modelo es reutilizado para evitar duplicacion de codigo.
		$this->load->model("Productos_model");
		$this->load->helper("form");
	}

	public function index()
	{
		$datos['random_number'] = random_int(0, 999);
		$this->load->view('ejercicio4.php', $datos);
	}
}
