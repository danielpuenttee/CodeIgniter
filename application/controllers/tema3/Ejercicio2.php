<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ejercicio2 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		//		El modelo es reutilizado para evitar duplicacion de codigo.
		$this->load->model("tema3/Tema3_Model");
		$this->load->library('table');
	}

	public function index()
	{
		$data['ejercicio2'] = $this->Tema3_Model->productos_categorias();
		unset($data['ejercicio2']['PK_ID_PRODUCTO']);
		unset($data['ejercicio2']['FK_ID_CATEGORIA']);

		$this->load->view('tema3/ejercicio2.php', $data);
	}
}
