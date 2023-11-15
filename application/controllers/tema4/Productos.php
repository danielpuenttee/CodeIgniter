<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

	public function __construct()
	{

		parent::__construct();

		$this->load->model("tema4/Productos_Model");

		$this->load->helper("form");
		$this->load->helper('url');

		$this->load->library('table');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->library('session');

		if(!isset($_SESSION)) session_start();
	}

	public function index()
	{
		$config = array();
		$config["base_url"] = '/codeigniter/tema4/productos/index/';
		$config["total_rows"] = $this->Productos_Model->productos_totales();
		$config["per_page"] = 3;

		$this->pagination->initialize($config);

		if($this->uri->segment(4) === 'cancelar') {
			if(isset($this->session->PAGINA)) header('Location: /codeigniter/tema4/productos/index/' . $this->session->PAGINA);
			else header('Location: /codeigniter/tema4/productos/index/');
		}

		$offset = ($this->uri->segment(4)) ? (int) $this->uri->segment(4) : 0;
		$pagina = $offset / $config["per_page"] + 1;

		$this->session->set_userdata(array('PAGINA' => $offset));
		$total_paginas = (int)ceil($config["total_rows"] / $config["per_page"]);

		$data['paginacion'] = [
			"LIMIT" => $config["per_page"],
			"OFFSET" => $offset,
			"PAGINA" => $pagina,
			"OFFSET_PAGINA" => $pagina !== 0 ? ($pagina - 1) * $config["per_page"] : 0,
			"TOTAL" => (int) $config["total_rows"],
			"TOTAL_PAGINAS" => $total_paginas
		];
		$data['productos'] = $this->Productos_Model->get_productos($config["per_page"], $offset);

		$this->load->view('tema4/listado.php', $data);
	}

	public function guardado_ok()
	{
		echo '<p style="color:green">Guardado correctamente</p>';
		$this->index();
	}

	public function guardar()
	{
		$this->form_validation->set_rules('txNombre', 'Nombre', 'required|alpha_numeric_spaces');
		$this->form_validation->set_rules('txPrecio', 'Precio', 'required|greater_than_equal_to[10]|less_than_equal_to[999.99]');
		$this->form_validation->set_rules('txCantidad', 'Cantidad', 'required|integer|greater_than_equal_to[0]');
		$this->form_validation->set_rules('selCategoria', 'Categoria', 'required');

		$id_producto = (int)$this->input->post('intId');

		if(!$this->form_validation->run()) $id_producto === 0 ? $this->ficha_nueva() : $this->ficha($id_producto);
		else {
			$valores = array(
				'NOMBRE' => $this->input->post('txNombre'),
				'MARCA' => $this->input->post('txMarca'),
				'PRECIO' => (int) $this->input->post('txPrecio'),
				'CANTIDAD' => (int) $this->input->post('txCantidad'),
				'FK_ID_CATEGORIA' => (int) $this->input->post('selCategoria'),
			);

			$this->Productos_Model->insertar_modificar_producto($id_producto, $valores);
			$this->guardado_ok();
		}
	}

	public function eliminado_ok()
	{
		echo '<p style="color:green">Eliminado correctamente</p>';
		$this->index();
	}

	public function eliminar()
	{

		$id_producto = (int)$this->input->post('intId');

		$this->Productos_Model->eliminar_producto($id_producto);
		$this->eliminado_ok();
	}

	public function ficha_nueva()
	{
		$data['categorias'] = $this->Productos_Model->categorias();
		$data['producto'] = null;
		$data['errores'] = $this->form_validation->error_array();
		$this->load->view('tema4/ficha.php', $data);
	}

	public function ficha(int $id_producto = NULL)
	{
		if(is_null($id_producto)) {
			http_response_code(404);
			exit;
		}

		$data['categorias'] = $this->Productos_Model->categorias();
		$producto = $this->Productos_Model->producto_por_id($id_producto);

		if(empty($producto)) http_response_code(404);

		$data['producto'] = $producto[0];
 		$this->load->view('tema4/ficha', $data);
	}
}
