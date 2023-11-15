<h1>Listado de productos</h1>

<div id="tabla">
<?php
	if($paginacion['TOTAL'] === 0): echo 'No hay pedidos que mostrar';
	else:
		foreach ($productos as $key => &$producto) {
			// Modifica cada campo del producto para convertirlo en un enlace
			$producto['NOMBRE'] = anchor(site_url('../tema4/productos/ficha/' . $producto['PK_ID_PRODUCTO']), $producto['NOMBRE']);
			$producto['MARCA'] = anchor(site_url('../tema4/productos/ficha/' . $producto['PK_ID_PRODUCTO']), is_null($producto['MARCA']) ? '-' : $producto['MARCA']);
			$producto['NOMBRE_CAT'] = anchor(site_url('../tema4/productos/ficha/' . $producto['PK_ID_PRODUCTO']), $producto['NOMBRE_CAT']);
			$producto['CANTIDAD'] = anchor(site_url('../tema4/productos/ficha/' . $producto['PK_ID_PRODUCTO']), $producto['CANTIDAD']);
			$producto['PRECIO'] = anchor(site_url('../tema4/productos/ficha/' . $producto['PK_ID_PRODUCTO']), $producto['PRECIO']);

			unset($producto['PK_ID_PRODUCTO']);
		}

		$this->table->set_heading('Nombre', 'Marca', 'Categoria', 'Cantidad', 'Precio');
		$template = array(
			'table_open' => '<table style="border: 3px solid black; text-align: center">',
			'heading_cell_start' => '<th style="border: 2px solid black">',
			'cell_start' => '<td style="border: 1px solid black;">',
			'cell_alt_start' => '<td style="border: 1px solid black;">',

		);

		$this->table->set_template($template);
		echo $this->table->generate($productos);
	endif;
?>
</div>
<br>
<br>

<div id="links">
	<?php
		$links = $this->pagination->create_links();
		echo $links;
	?>
	<br>
	<?php
		if (count($productos) === 0):
			echo 'No hay productos que mostrar';
		else:
			if (count($productos) !== 1):
				echo "Mostrando productos ";
				echo $paginacion['TOTAL_PAGINAS'] === 0 ? '0' : (int)$paginacion['OFFSET'] + 1;
				echo " al ";
				echo $paginacion['LIMIT'] + $paginacion['OFFSET_PAGINA'] < $paginacion['TOTAL'] ?
					$paginacion['LIMIT'] + $paginacion['OFFSET_PAGINA'] : $paginacion['TOTAL'];
			else:
				echo "Mostrando producto " . $paginacion['OFFSET'] + 1;
			endif;
			echo " de " . $paginacion['TOTAL'] . " productos totales";
		endif;
	?>
</div>
<br>
<br>

<div id="Nuevo pedido">
	<?php
		echo form_open('../tema4/productos/ficha_nueva', 'get');
		$submit_attributes = array(
			'name' => 'btSubmit',
			'id' => 'btSubmit',
			'class' => 'submit',
			'value' => 'Nuevo pedido'
		);
		echo form_submit($submit_attributes);
		echo form_close()

	?>
</div>

