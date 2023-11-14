<?php

class Productos_Model extends CI_Model
{

	public function productos_totales()
	{
		return $this->db->count_all('PRODUCTO');
	}


	public function get_productos($limit, $start)
	{
		$this->db->join('CATEGORIA', 'PRODUCTO.FK_ID_CATEGORIA = CATEGORIA.PK_ID_CATEGORIA');
		$this->db->select('PRODUCTO.PK_ID_PRODUCTO, PRODUCTO.NOMBRE, PRODUCTO.MARCA, CATEGORIA.NOMBRE as NOMBRE_CAT, PRODUCTO.CANTIDAD, PRODUCTO.PRECIO');
		$this->db->limit($limit, $start);
		$this->db->order_by('PRODUCTO.NOMBRE');
		return $this->db->get('PRODUCTO')->result_array();
	}


    public function productos()
    {
        return $this->db->get('PRODUCTO')->result_array();
    }


    public function categorias()
    {
        return $this->db->get('CATEGORIA')->result_array();
    }


    public function productos_categorias()
    {
        $this->db->join('CATEGORIA', 'PRODUCTO.FK_ID_CATEGORIA = CATEGORIA.PK_ID_CATEGORIA');
        $this->db->order_by('PRODUCTO.NOMBRE', 'DESC');
        $this->db->select('PRODUCTO.NOMBRE, PRODUCTO.MARCA, CATEGORIA.NOMBRE as NOMBRE_CAT, PRODUCTO.CANTIDAD, PRODUCTO.PRECIO');

        return $this->db->get('PRODUCTO')->result_array();
    }


	public function producto_por_id(int $id_producto)
	{
		$this->db->join('CATEGORIA', 'PRODUCTO.FK_ID_CATEGORIA = CATEGORIA.PK_ID_CATEGORIA');
		$this->db->select('PRODUCTO.PK_ID_PRODUCTO, PRODUCTO.NOMBRE, PRODUCTO.MARCA, CATEGORIA.NOMBRE as NOMBRE_CAT, 
			PRODUCTO.FK_ID_CATEGORIA, PRODUCTO.CANTIDAD, PRODUCTO.PRECIO');
		$this->db->where('PRODUCTO.PK_ID_PRODUCTO', $id_producto);

		return $this->db->get('PRODUCTO')->result_array();
	}

	public function insertar_modificar_producto(int $id_pedido, array $valores)
	{
		// Comprueba si el pedido ya existe
		$this->db->where('PK_ID_PRODUCTO', $id_pedido);
		$query = $this->db->get('PRODUCTO');

		// Si el pedido no existe, crea uno nuevo
		if ($query->num_rows() == 0) {
			$valores['PK_ID_PRODUCTO'] = $id_pedido; // Asigna el ID del pedido
			$this->db->insert('PRODUCTO', $valores);
		} else {
			// Si el pedido ya existe, actualiza los valores
			$this->db->where('PK_ID_PRODUCTO', $id_pedido);
			$this->db->update('PRODUCTO', $valores);
		}
	}
	public function eliminar_producto(int $id_producto)
	{
		$this->db->where('PK_ID_PRODUCTO', $id_producto);
		return $this->db->delete('PRODUCTO');
	}
    public function insertar_productos(array $productos)
    {
        return $this->db->insert_batch('PRODUCTO', $productos);
    }
}


