<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ejercicio4 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper("form");
		$this->load->library('form_validation');
	}

	public function index()
	{
		$datos['random_number'] = random_int(0, 999);
		$this->load->view('tema3/ejercicio4.php', $datos);
	}
}
