<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Ficha privada vehiculo</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
</head>

<body>
<div id="titulo">
    <h1>Talleres Guzmán S.L. - Zona privada</h1>
    <h2>Vehiculo <?= is_null($vehiculo) ? 'Nuevo' : ('#' . $vehiculo['MATRICULA']) ?></h2>
</div>

<div id="ficha">
	<?= form_open_multipart(RUTA_ADMINISTRACION . '/vehiculos/guardar'); ?>

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
		echo form_error('txMatricula', '<p style=color:red>', '</p>');

		$value = '';
		if(!is_null($vehiculo)) $value = $vehiculo['MATRICULA'];
		if(!empty(validation_errors())) $value = set_value('txMatricula');
		$marca_attributes = array(
			'name' => 'txMatricula',
			'id' => 'txMatricula',
			'class' => 'input',
            'placeholder' => 'Ingrese la matrícula',
			'value' => $value,
    		);

		echo form_label('Matricula ', 'txMatricula');
		echo form_input($marca_attributes);
		?>
	</div>
    <br>

    <div id="marca">
        <?php
        echo form_error('txMarca', '<p style=color:red>', '</p>');

        $value = '';
        if(!is_null($vehiculo)) $value = $vehiculo['MARCA'];
        if(!empty(validation_errors())) $value = set_value('txMarca');

        $opciones_atributos = array(
            'name' => 'txMarca',
            'id' => 'txMarca',
            'placeholder' => 'Ingrese la marca',
            'class' => 'input',
            'value' => $value,
        );

        echo form_label('Marca ', 'txMarca');
        echo form_input($opciones_atributos);
        ?>
    </div>
    <br>

	<div id="modelo">
		<?php
		echo form_error('txModelo', '<p style=color:red>', '</p>');

		$value = '';
		if(!is_null($vehiculo)) $value = $vehiculo['MODELO'];
		if(!empty(validation_errors())) $value = set_value('txModelo');

		$atributos = array(
			'name' => 'txModelo',
			'id' => 'txModelo',
			'class' => 'input',
			'placeholder' => 'Ingrese el modelo',
			'value' => $value,
		);

		echo form_label('Modelo ', 'txModelo');
		echo form_input($atributos);
		?>
	</div>
	<br>

    <div id="ubicacion">
        <?php
		echo form_error('txUbicacion', '<p style=color:red>', '</p>');

		$value = '';
		if(!is_null($vehiculo)) $value = $vehiculo['UBICACION'];
		if(!empty(validation_errors())) $value = set_value('txUbicacion');
        $atributos = array(
            'name' => 'txUbicacion',
            'id' => 'txUbicacion',
            'class' => 'input',
            'placeholder' => !is_null($vehiculo) ? '' : 'Ingrese el precio',
            'value' => $value,
        );

        echo form_label('Ubicacion ', 'txUbicacion');
        echo form_input($atributos);
        ?>
    </div>
    <br>

    <div id="foto_vehiculo">
        <p style="color: red"><?= $errores['foto'] ?></p>

        <?php if (is_null($vehiculo) || is_null($vehiculo['RENOMBRADO'])):
            $atributos = array(
                'name' => 'foto_vehiculo',
                'id' => 'foto_vehiculo',
                'class' => 'input',
                'type' => 'file',
            );

            echo form_label('Foto del Vehículo: ', 'foto_vehiculo');
            echo form_upload($atributos);
//        ?>
        <?php else: ?>
           <img style="max-width: 500px; max-height: 500px" src=<?= '/codeigniter/imagenes/vehiculos/' . $vehiculo['RENOMBRADO'] ?>>
        <?php endif; ?>

     </div>

    <div id="reservas">
        <?php if(!is_null($vehiculo)): ?>
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
        <?php else: ?>
            <h3>Un vehículo nuevo no tiene reservas asignadas</h3>
        <?php endif; ?>

    </div>
    <br>

    <div id="botones">
        <button type="button" onclick="window.location.href='<?=site_url(RUTA_ADMINISTRACION . '/vehiculos/listado/volver')?>'">Volver</button>
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
</body>
</html>

