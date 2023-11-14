<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ejercicio3 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		//		El modelo es reutilizado para evitar duplicacion de codigo.
		$this->load->model("tema3/Tema3_Model");
		$this->load->library('table');
		$this->load->library('pagination');
	}

	public function index()
	{
		$config = array();
		$config["base_url"] = '/codeigniter/tema3/ejercicio3/index/';
		$config["total_rows"] = $this->Tema3_Model->productos_totales();
		$config["per_page"] = 3;

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? (int) $this->uri->segment(4) / $config["per_page"] + 1 : 0;
		$total_paginas = (int)ceil($config["total_rows"] / $config["per_page"]);

		$data['paginacion'] = [
			"LIMIT" => $config["per_page"] = 3,
			"OFFSET" => $page !== 0 ? ($page - 1) * $config["per_page"] : 0,
			"TOTAL" => (int) $config["total_rows"],
			"TOTAL_PAGINAS" => $total_paginas
 		];
		$data['links'] = $this->pagination->create_links();
		$data['productos'] = $this->Tema3_Model->get_productos($config["per_page"], $page);

		$this->load->view('tema3/ejercicio3.php', $data);
	}
}
