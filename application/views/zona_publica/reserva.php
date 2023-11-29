<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Reserva publica de vehiculo</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
</head>

<body>
<div id="titulo">
    <h1>Talleres Guzmán S.L.</h1>
    <h2>Ficha del Vehiculo <?= $vehiculo['MATRICULA'] ?></h2>
</div>

<div id="ficha">
    <?= form_open('zona_publica/reserva/guardar'); ?>

    <div id="id">
        <?php
        $atributos = array(
            'name' => 'intId',
            'id' => 'intId',
            'class' => 'input',
            'value' => is_null($vehiculo) ? 0 : (int)$vehiculo['PK_ID_VEHICULO'],
            'readonly' => 'readonly',
            'style' => 'display: none;'
        );
        echo form_input($atributos);
        ?>
    </div>

    <div id="matricula">
        <?php
        $matricula_attributes = array(
            'name' => 'txMatricula',
            'id' => 'txMatricula',
            'class' => 'input',
            'value' => $vehiculo['MATRICULA'],
            'readonly' => 'readonly',
        );

        echo form_label('Matricula ', 'txMatricula');
        echo form_input($matricula_attributes);
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

    <div id="reserva">
        <h3>Datos de reserva</h3>
        <div id="empleado">
            <?php
            echo form_error('selEmpleado', '<p style=color:red>', '</p>');

            $opciones_atributos = array(
                'id' => 'selMarca',
                'class' => 'input',
                'value' => set_value('selEmpleado'),
            );

            echo form_label('Empleado ', 'selEmpleado');
            echo form_dropdown('selEmpleado', $empleados, set_value('selEmpleado'), $opciones_atributos);
            ?>
        </div>
        <br>

        <div id="desde">
            <?php if (isset($validation_errors['fecha'])) ?><span style="color: red"> <?= $validation_errors['fecha']; ?> </span>

            <?php
            form_error('dtDesde', '<span style=color:red>', '</p>');

            $atributos = array(
                'name' => 'dtDesde',
                'id' => 'dtDesde',
                'type' => 'datetime-local',
                'value' => set_value('dtDesde'),
                'required' => 'required'
            );
            echo form_label('Desde ', 'dtDesde');
            echo form_input($atributos);
            ?>
        </div>
        <br>
        <div id="hasta">
            <?php
            echo form_error('dtHasta', '<span style=color:red>', '</p>');

            $atributos = array(
                'name' => 'dtHasta',
                'id' => 'dtHasta',
                'type' => 'datetime-local',
                'value' => set_value('dtHasta'),
                'required' => 'required'
            );
            echo form_label('Hasta ', 'dtHasta');
            echo form_input($atributos);
            ?>
        </div>

    </div>
    <br>

    <div id="botones">
        <button type="button" onclick="window.location.href='<?=site_url('/zona_publica/ficha/index/' . $vehiculo['PK_ID_VEHICULO'])?>'">Volver</button>
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
