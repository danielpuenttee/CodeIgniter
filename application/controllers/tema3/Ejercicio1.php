<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ejercicio1 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model("tema3/Tema3_Model");
	}

	public function index()
	{
		$data['apartado1'] = $this->Tema3_Model->productos();
		$data['apartado2'] = $this->Tema3_Model->categorias();
		$data['apartado3'] = $this->Tema3_Model->productos_categorias();
		$data['apartado4'] = $this->Tema3_Model->zapatillas();
		$data['apartado5'] = $this->Tema3_Model->zapas();
		$data['apartado6'] = $this->Tema3_Model->media_precios();
		$data['apartado7'] = $this->Tema3_Model->total_productos();
		$data['apartado8'] = $this->Tema3_Model->productos_mas_de(10);

		$data['apartado9'] = array(
			array(
					"NOMBRE" => "Nike Dunk Low Panda",
					"MARCA" => "Nike",
					"FK_ID_CATEGORIA" => 1,
					"CANTIDAD" => 5,
					"PRECIO" => 130.00),
				array(
						"NOMBRE" => "Adidas Gazelle Black",
						"MARCA" => "Adidas",
						"FK_ID_CATEGORIA" => 1,
						"CANTIDAD" => 10,
						"PRECIO" => 80.00 ));
		$data['apartado9'] = array();
		
		$this->Tema3_Model->insertar_pedidos($data['apartado9']);

		$data['apartado10'] = array(
			'VIEJO' => array(
				"PK_ID_PRODUCTO" => 7,
				"NOMBRE" => "Abrigo acolchado",
				"MARCA" => "J&J",
				"FK_ID_CATEGORIA" => 3,
				"CANTIDAD" => 10,
				"PRECIO" => 200.87),
			'NUEVO' => array(
				"PK_ID_PRODUCTO" => 7,
				"NOMBRE" => "Abrigo acolchado",
				"MARCA" => "Jack & Jones",
				"FK_ID_CATEGORIA" => 3,
				"CANTIDAD" => 8,
				"PRECIO" => 350.99)
		);
		$this->Tema3_Model->modificar_pedido($data['apartado10']['NUEVO']);

		$this->load->view('tema3/ejercicio1.php', $data);
	}
}
