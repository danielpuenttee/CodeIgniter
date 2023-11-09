<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ejercicio3 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		//		El modelo es reutilizado para evitar duplicacion de codigo.
		$this->load->model("Productos_model");
		$this->load->library('table');
		$this->load->library('pagination');
	}

	public function index()
	{
		$config = array();
		$config["base_url"] = '/codeigniter/ejercicio3/index/';
		$config["total_rows"] = $this->Productos_model->productos_totales();
		$config["per_page"] = 2;

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['links'] = $this->pagination->create_links();
		$data['productos'] = $this->Productos_model->get_productos($config["per_page"], $page);

		$this->load->view('ejercicio3.php', $data);
	}
}
