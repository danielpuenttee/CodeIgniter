<h2>Ficha de Producto</h2>

<div id="ficha">
	<?= form_open('../tema4/productos/guardar'); ?>



	<div id="id">
		<?php
			echo form_open('../tema4/productos/index');
			$submit_attributes = array(
				'name' => 'intId',
				'id' => 'intId',
				'class' => 'input',
				'value' => is_null($producto) ? 0 : (int)$producto['PK_ID_PRODUCTO'],
				'readonly' => 'readonly',
				'style' => 'display: none;'
			);
			echo form_input($submit_attributes);
		?>
	</div>


	<div id="nombre">
		<?php
		echo form_error('txNombre', '<p style=color:red>', '</p>');

		$value = '';
		if(!is_null($producto)) $value = $producto['NOMBRE'];
		if(!empty(validation_errors())) $value = set_value('txNombre');
		$nombre_attributes = array(
			'name' => 'txNombre',
			'id' => 'txNombre',
			'class' => 'input',
			'placeholder' => !is_null($producto) ? '' : 'Ingrese el nombre',
			'value' => $value,
		);

		echo form_label('Nombre ', 'txNombre');
		echo form_input($nombre_attributes);
		?>
	</div>
	<br>
	<br>

	<div id="marca">
		<?php
		echo form_error('txMarca', '<p style=color:red>', '</p>');

		$value = '';
		if(!is_null($producto)) $value = $producto['MARCA'];
		if(!empty(validation_errors())) $value = set_value('txMarca');
		$marca_attributes = array(
			'name' => 'txMarca',
			'id' => 'txMarca',
			'class' => 'input',
			'placeholder' => !is_null($producto) ? '' : 'Ingrese la marca',
			'value' => $value
		);

		echo form_label('Marca ', 'txMarca');
		echo form_input($marca_attributes);
		?>
	</div>
	<br>
	<br>

	<div id="precio">
		<?php
		echo form_error('txPrecio', '<p style=color:red>', '</p>');

		$value = '';
		if(!is_null($producto)) $value = $producto['PRECIO'];
		if(!empty(validation_errors())) $value = set_value('txPrecio');
		$precio_attributes = array(
			'name' => 'txPrecio',
			'id' => 'txPrecio',
			'class' => 'input',
			'placeholder' => !is_null($producto) ? '' : 'Ingrese el precio',
			'value' => $value
		);

		echo form_label('Precio ', 'txPrecio');
		echo form_input($precio_attributes);
		?>
	</div>
	<br>
	<br>

	<div id="cantidad">
		<?php
		echo form_error('txCantidad', '<p style=color:red>', '</p>');

		$value = '';
		if(!is_null($producto)) $value = $producto['CANTIDAD'];
		if(!empty(validation_errors())) $value = set_value('txCantidad');
		$cantidad_attributes = array(
			'name' => 'txCantidad',
			'id' => 'txCantidad',
			'class' => 'input',
			'placeholder' => !is_null($producto) ? '' : 'Ingrese la cantidad',
			'value' => $value
		);

		echo form_label('Cantidad ', 'txCantidad');
		echo form_input($cantidad_attributes);
		?>
	</div>
	<br>
	<br>

	<div id="categoria">
		<?php
		echo form_error('selCategoria', '<p style=color:red>', '</p>');

		$value = '';
		if(!is_null($producto)) $value = $producto['FK_ID_CATEGORIA'];
		if(!empty(validation_errors())) $value = set_value('selCategoria');

		$opciones = array(
			'' => 'Seleccione una categoría',
		);
		foreach($categorias as $index => $categoria) {
			$opciones[$categoria['PK_ID_CATEGORIA']] = $categoria['NOMBRE'];
		}
		$opciones_atributos = array(
			'id' => 'selCategoria',
			'class' => 'input',
			'value' => $value
		);

		echo form_label('Categoría ', 'selCategoria');
		echo form_dropdown('selCategoria', $opciones, $value, $opciones_atributos);
		?>
	</div>
	<br>
	<br>

	<div id="guardar">
		<?php
		$submit_attributes = array(
			'name' => 'btSubmit',
			'id' => 'btSubmit',
			'class' => 'submit',
			'value' => 'Guardar'
		);
		echo form_submit($submit_attributes);
		?>
	</div>
	<?= form_close(); ?>
</div>


<?php if(!is_null($producto)): ?>
	<div id="eliminar">
		<?php
		echo form_open('../tema4/productos/eliminar');
		$submit_attributes = array(
			'name' => 'intId',
			'id' => 'intId',
			'class' => 'input',
			'value' => is_null($producto) ? 0 : (int)$producto['PK_ID_PRODUCTO'],
			'readonly' => 'readonly',
			'style' => 'display: none;'
		);
		echo form_input($submit_attributes);

		$submit_attributes = array(
			'name' => 'btEliminar',
			'id' => 'btEliminar',
			'class' => 'submit',
			'value' => 'Eliminar',
		);
		echo form_submit($submit_attributes);
		echo form_close()
		?>
	</div>
	<br><br>
<?php endif; ?>

<div id="Cancelar">
	<?php
		echo form_open('../tema4/productos/index/cancelar');
		$submit_attributes = array(
			'name' => 'btCancel',
			'id' => 'btCancel',
			'class' => 'submit',
			'value' => 'Cancelar',
		);
		echo form_submit($submit_attributes);
		echo form_close()
	?>
</div>

