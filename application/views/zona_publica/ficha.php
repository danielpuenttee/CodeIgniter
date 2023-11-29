<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Ficha publica vehiculo</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
</head>

<body>
<div id="titulo">
    <h1>Talleres Guzmán S.L.</h1>
    <h2>Ficha del Vehiculo <?= $vehiculo['MATRICULA'] ?></h2>
</div>

<div id="ficha">
	<?= form_open('zona_publica/listado/listado/volver'); ?>

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
        $opciones = array(
            $vehiculo['PK_ID_VEHICULO'] => $vehiculo['MARCA'],
        );

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
		$atributos = array(
			'name' => 'txModelo',
			'id' => 'txModelo',
			'class' => 'input',
			'value' => $vehiculo['MODELO'],
            'readonly' => 'readonly'
		);

		echo form_label('Modelo ', 'txModelo');
		echo form_input($atributos);
		?>
	</div>
	<br>

    <div id="ubicacion">
        <?php
        $atributos = array(
            'name' => 'txUbicacion',
            'id' => 'txUbicacion',
            'class' => 'input',
            'value' => $vehiculo['UBICACION'],
            'readonly' => 'readonly'
        );

        echo form_label('Ubicacion ', 'txUbicacion');
        echo form_input($atributos);
        ?>
    </div>
    <br>

    <div id="foto_vehiculo">
        <?php if (!is_null($vehiculo) && !is_null($vehiculo['RENOMBRADO'])) ?>
            <img style="max-width: 500px; max-height: 500px" src=<?= '/codeigniter/imagenes/vehiculos/' . $vehiculo['RENOMBRADO'] ?>>
    </div>

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
</body>
</html>

