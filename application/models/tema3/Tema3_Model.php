<?php
class Tema3_Model extends CI_Model {

//	Ejercicio 1
	//	1. Realiza una función que devuelva todos los productos.
	public function productos() {
		return $this->db->get('PRODUCTO')->result_array();
	}

	// 2. Realiza una función que devuelva todas las categorías.
	public function categorias() {
		return $this->db->get('CATEGORIA')->result_array();
	}

	// 3. Realiza una función que devuelva todos los productos junto con sus categorías
	// ordenadas descendientemente por el campo NOMBRE.
	public function productos_categorias() {
		$this->db->join('CATEGORIA', 'PRODUCTO.FK_ID_CATEGORIA = CATEGORIA.PK_ID_CATEGORIA');
		$this->db->order_by('PRODUCTO.NOMBRE', 'DESC');
		$this->db->select('PRODUCTO.NOMBRE, PRODUCTO.MARCA, CATEGORIA.NOMBRE as NOMBRE_CAT, PRODUCTO.CANTIDAD, PRODUCTO.PRECIO');

		return $this->db->get('PRODUCTO')->result_array();
	}

	// 4. Realiza una función que devuelva aquellos productos cuya categoría sea ‘Zapatillas’.
	public function zapatillas() {
		$this->db->join('CATEGORIA', 'PRODUCTO.FK_ID_CATEGORIA = CATEGORIA.PK_ID_CATEGORIA');
		$this->db->select('PRODUCTO.*, CATEGORIA.NOMBRE as NOMBRE_CAT');
		$this->db->where('CATEGORIA.NOMBRE', 'Zapatillas');

		return $this->db->get('PRODUCTO')->result_array();
	}

	// 5. Realiza una función que devuelva aquellos productos cuyo nombre empiece por ‘Zapa’.
	public function zapas() {
		$this->db->join('CATEGORIA', 'PRODUCTO.FK_ID_CATEGORIA = CATEGORIA.PK_ID_CATEGORIA');
		$this->db->select('PRODUCTO.*, CATEGORIA.NOMBRE as NOMBRE_CAT');
		$this->db->like('CATEGORIA.NOMBRE', 'Zapa', 'after');

		return $this->db->get('PRODUCTO')->result_array();
	}

	// 6. Realiza una función que devuelva la media de precios.
	public function media_precios() {
		$this->db->select_avg('PRECIO');

		return $this->db->get('PRODUCTO')->result_array();
	}

	// 7. Realiza una función que devuelva para cada categoría, el número de productos que existen.
	public function total_productos() {
		$this->db->select('CATEGORIA.NOMBRE as NOMBRE, SUM(PRODUCTO.CANTIDAD) as NUMERO_PRODUCTOS');
		$this->db->join('CATEGORIA', 'PRODUCTO.FK_ID_CATEGORIA = CATEGORIA.PK_ID_CATEGORIA', 'left');
		$this->db->group_by('CATEGORIA.NOMBRE');

//		//	Si el número de productos se refiere a la cantidad de productos distintos:
//		$this->db->select('CATEGORIA.NOMBRE as NOMBRE, COUNT(PRODUCTO.PK_ID_PRODUCTO) as NUMERO_PRODUCTOS');
//		$this->db->join('CATEGORIA', 'PRODUCTO.FK_ID_CATEGORIA = CATEGORIA.PK_ID_CATEGORIA', 'left');
//		$this->db->group_by('CATEGORIA.NOMBRE');

		return $this->db->get('PRODUCTO')->result_array();
	}


	// 8. Realiza una función que devuelva aquellas categorías cuya suma de productos sea mayor a 10 productos.
	public function productos_mas_de(int $numero) {
		$this->db->select('CATEGORIA.NOMBRE as NOMBRE, SUM(PRODUCTO.CANTIDAD) as NUMERO_PRODUCTOS');
		$this->db->join('CATEGORIA', 'PRODUCTO.FK_ID_CATEGORIA = CATEGORIA.PK_ID_CATEGORIA', 'left');
		$this->db->group_by('CATEGORIA.NOMBRE');
		$this->db->having('NUMERO_PRODUCTOS >=', $numero);

////			Si el número de productos se refiere a la cantidad de productos distintos:
//		$this->db->select('CATEGORIA.NOMBRE as NOMBRE, COUNT(PRODUCTO.PK_ID_PRODUCTO) as NUMERO_PRODUCTOS');
//		$this->db->join('CATEGORIA', 'PRODUCTO.FK_ID_CATEGORIA = CATEGORIA.PK_ID_CATEGORIA', 'left');
//		$this->db->group_by('CATEGORIA.NOMBRE');
//		$this->db->having('NUMERO_PRODUCTOS >=', $numero);

		return $this->db->get('PRODUCTO')->result_array();
	}

	// 9. Realiza una función que inserte 2 nuevos productos en la tabla productos.
	// Los 2 productos deben de ser completamente distintos.
	public function insertar_pedidos(array $pedidos) {
		return;
		return $this->db->insert_batch('PRODUCTO', $pedidos);
	}

	// 10. Realiza una función que modifique el producto con PK_ID_PRODUCTO = 7 de tal forma que:
	//		La marca sea Jack & Jones.
	//		La cantidad sea 8.
	//		El precio sea 350.99€.
	public function modificar_pedido(array $pedido) {
		$id = array('PK_ID_PRODUCTO' => $pedido['PK_ID_PRODUCTO']);
		unset($pedido['PK_ID_PRODUCTO']);
		$modifiers = $pedido;

		return $this->db->update('PRODUCTO', $modifiers, $id);
	}


//	Ejercicio 3: paginación
	public function productos_totales() {
		return $this->db->count_all('PRODUCTO');
	}
	public function get_productos($limit, $start) {
		$this->db->join('CATEGORIA', 'PRODUCTO.FK_ID_CATEGORIA = CATEGORIA.PK_ID_CATEGORIA');
		$this->db->select('PRODUCTO.PK_ID_PRODUCTO, PRODUCTO.NOMBRE, PRODUCTO.MARCA, CATEGORIA.NOMBRE as NOMBRE_CAT, PRODUCTO.CANTIDAD, PRODUCTO.PRECIO');
		$this->db->limit($limit, $start);
		$this->db->order_by('PRODUCTO.NOMBRE');
		return $this->db->get('PRODUCTO')->result_array();
	}

}


