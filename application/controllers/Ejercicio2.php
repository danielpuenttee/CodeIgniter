<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ejercicio2 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		//		El modelo es reutilizado para evitar duplicacion de codigo.
		$this->load->model("Productos_model");
		$this->load->library('table');
	}

	public function index()
	{
		$data['ejercicio2'] = $this->Productos_model->productos_categorias();
		$this->load->view('ejercicio2.php', $data);
	}
}
