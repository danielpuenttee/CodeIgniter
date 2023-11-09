<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ejercicio1 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model("Productos_model");
	}

	public function index()
	{
		$data['apartado1'] = $this->Productos_model->productos();
		$data['apartado2'] = $this->Productos_model->categorias();
		$data['apartado3'] = $this->Productos_model->productos_categorias();
		$data['apartado4'] = $this->Productos_model->zapatillas();
		$data['apartado5'] = $this->Productos_model->zapas();
		$data['apartado6'] = $this->Productos_model->media_precios();
		$data['apartado7'] = $this->Productos_model->total_productos();
		$data['apartado8'] = $this->Productos_model->productos_mas_de(10);

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
				"PRECIO" => 80.00 )
			);
		$this->Productos_model->insertar_pedidos($data['apartado9']);

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
		$this->Productos_model->modificar_pedido($data['apartado10']['NUEVO']);

		$this->load->view('ejercicio1.php', $data);
	}
}
