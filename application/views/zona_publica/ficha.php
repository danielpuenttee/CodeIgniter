<h2>Ficha del Vehiculo <?= $vehiculo['MATRICULA'] ?></h2>

<div id="ficha">
	<?= form_open('zona_publica/listado/index/volver'); ?>

	<div id="id">
		<?php
			$submit_attributes = array(
				'name' => 'intId',
				'id' => 'intId',
				'class' => 'input',
				'value' => is_null($vehiculo) ? 0 : (int)$vehiculo['PK_ID_VEHICULO'],
				'readonly' => 'readonly',
				'style' => 'display: none;'
			);
			echo form_input($submit_attributes);
		?>
	</div>

	<div id="matricula">
		<?php
//		echo form_error('selMarca', '<p style=color:red>', '</p>');

//		$value = '';
//		if(!is_null($vehiculo)) $value = $vehiculo['MARCA'];
//		if(!empty(validation_errors())) $value = set_value('txMarca');
		$marca_attributes = array(
			'name' => 'txMatricula',
			'id' => 'txMatricula',
			'class' => 'input',
			'value' => $vehiculo['MATRICULA'],
            'readonly' => 'readonly',
    		);

		echo form_label('Matricula ', 'txMatricula');
		echo form_input($marca_attributes);
		?>
	</div>
    <br>

    <div id="marca">
        <?php
//        echo form_error('selMarca', '<p style=color:red>', '</p>');

//        $value = '';
//        if(!is_null($vehiculo)) $value = $vehiculo['MATRICULA'];
//        if(!empty(validation_errors())) $value = set_value('selMarca');

        $opciones = array(
            $vehiculo['PK_ID_VEHICULO'] => $vehiculo['MARCA'],
        );

//        TODO: change to marcas
//        foreach($categorias as $index => $categoria) {
//            $opciones[$categoria['PK_ID_CATEGORIA']] = $categoria['MARCA'];
//        }

        $opciones_atributos = array(
            'id' => 'selMarca',
            'class' => 'input',
            'value' => $vehiculo['MARCA'],
            'disabled' => 'disabled',
            'style' => 'color: #000000;'
        );

        echo form_label('Marca ', 'selMarca');
        echo form_dropdown('selMarca', $opciones, $vehiculo['MARCA'], $opciones_atributos);
        ?>
    </div>
    <br>

	<div id="modelo">
		<?php
//		echo form_error('txPrecio', '<p style=color:red>', '</p>');

//		$value = '';
//		if(!is_null($vehiculo)) $value = $vehiculo['MODELO'];
//		if(!empty(validation_errors())) $value = set_value('txPrecio');
		$precio_attributes = array(
			'name' => 'txModelo',
			'id' => 'txModelo',
			'class' => 'input',
//			'placeholder' => !is_null($vehiculo) ? '' : 'Ingrese el precio',
			'value' => $vehiculo['MODELO'],
            'readonly' => 'readonly'
		);

		echo form_label('Modelo ', 'txModelo');
		echo form_input($precio_attributes);
		?>
	</div>
	<br>

    <div id="ubicacion">
        <?php
//		echo form_error('txPrecio', '<p style=color:red>', '</p>');

//		$value = '';
//		if(!is_null($vehiculo)) $value = $vehiculo['MODELO'];
//		if(!empty(validation_errors())) $value = set_value('txPrecio');
        $precio_attributes = array(
            'name' => 'txUbicacion',
            'id' => 'txUbicacion',
            'class' => 'input',
//            'placeholder' => !is_null($vehiculo) ? '' : 'Ingrese el precio',
            'value' => $vehiculo['UBICACION'],
            'readonly' => 'readonly'
        );

        echo form_label('Ubicacion ', 'txUbicacion');
        echo form_input($precio_attributes);
        ?>
    </div>
    <br>

    <div id="reservas">
        <h3>Reservas del vehículo</h3>
        <?php
        if(empty($reservas)): echo "No hay reservas generadas en este vehiculo";
        else:
            $this->table->set_heading('Desde', 'Hasta', 'Empleado', 'Estado');

            $template = array(
            'table_open' => '<table style="border: 3px solid black; text-align: center">',
                'heading_cell_start' => '<th style="border: 2px solid black">',
                    'cell_start' => '<td style="border: 1px solid black;">',
                    'cell_alt_start' => '<td style="border: 1px solid black;">'
                    );
                    $this->table->set_template($template);

                    echo $this->table->generate($reservas);
        endif;
        ?>
        <br>
        <button type="button" onclick="window.location.href='<?=site_url('/zona_publica/reserva/index/' . $vehiculo['PK_ID_VEHICULO'])?>'">Nueva Reserva</button>
    </div>
    <br>
    <br>

	<div id="volver">
		<?php
		$submit_attributes = array(
			'name' => 'btSubmit',
			'id' => 'btSubmit',
			'class' => 'submit',
			'value' => 'Volver'
		);
		echo form_submit($submit_attributes);
		?>
	</div>
	<?= form_close(); ?>
</div>


    <?php //if(!is_null($producto)): ?>
    <!--	<div id="eliminar">-->
    <!--		--><?php
    //		echo form_open('../productos/eliminar');
    //		$submit_attributes = array(
    //			'name' => 'intId',
    //			'id' => 'intId',
    //			'class' => 'input',
    //			'value' => is_null($producto) ? 0 : (int)$producto['PK_ID_PRODUCTO'],
    //			'readonly' => 'readonly',
    //			'style' => 'display: none;'
    //		);
    //		echo form_input($submit_attributes);
    //
    //		$submit_attributes = array(
    //			'name' => 'btEliminar',
    //			'id' => 'btEliminar',
    //			'class' => 'submit',
    //			'value' => 'Eliminar',
    //		);
    //		echo form_submit($submit_attributes);
    //		echo form_close()
    //		?>
    <!--	</div>-->
    <!--	<br><br>-->
    <?php //endif; ?>



