<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Listado Empleados</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
</head>
<body>

<div id="titulo">
    <h1>Talleres Guzmán S.L. - Zona privada</h1>
    <h2>Empleado <?= is_null($empleado) ? 'Nuevo' : ('#' . $empleado['IDENTIFICADOR']) ?></h2>
</div>


<div id="ficha">
    <?= form_open(RUTA_ADMINISTRACION . '/empleados/guardar'); ?>

    <div id="id">
        <?php
        $submit_attributes = array(
            'name' => 'intId',
            'id' => 'intId',
            'class' => 'input',
            'value' => is_null($empleado) ? 0 : (int)$empleado['PK_ID_EMPLEADO'],
            'readonly' => 'readonly',
            'style' => 'display: none;'
        );
        echo form_input($submit_attributes);
        ?>
    </div>

    <div id="identificador">
        <?php
        $marca_attributes = array(
            'name' => 'txIdentificador',
            'id' => 'txIdentificador',
            'class' => 'input',
            'value' => is_null($empleado) ? $nuevo_id : $empleado['IDENTIFICADOR'],
            'readonly' => 'readonly',
        );

        echo form_label('Identificador ', 'txIdentificador');
        echo form_input($marca_attributes);
        ?>
    </div>
    <br>

    <div id="nombre">
        <?php
        echo form_error('txNombre', '<p style=color:red>', '</p>');

        $value = '';
        if(!is_null($empleado)) $value = $empleado['NOMBRE'];
        if(!empty(validation_errors())) $value = set_value('txNombre');
        $nombre_atributos = array(
            'name' => 'txNombre',
            'id' => 'txNombre',
            'class' => 'input',
			'placeholder' => 'Ingrese el nombre',
            'value' => $value,
        );

        echo form_label('Nombre ', 'txNombre');
        echo form_input($nombre_atributos);
        ?>
    </div>
    <br>

    <div id="apellidos">
        <?php
        echo form_error('txApellidos', '<p style=color:red>', '</p>');

        $value = '';
        if(!is_null($empleado)) $value = $empleado['APELLIDOS'];
        if(!empty(validation_errors())) $value = set_value('txApellidos');
        $nombre_atributos = array(
            'name' => 'txApellidos',
            'id' => 'txApellidos',
            'class' => 'input',
            'placeholder' => 'Ingrese los apellidos',
            'value' => $value,
        );

        echo form_label('Apellidos ', 'txApellidos');
        echo form_input($nombre_atributos);
        ?>
    </div>
    <br>

    <div id="nacimiento">
        <?php
        $value = '';
        if(!is_null($empleado)) $value = $empleado['FECHA_NACIMIENTO'];
        if(!empty(validation_errors())) $value = set_value('dtNacimiento');
        $atributos = array(
            'name' => 'dtNacimiento',
            'id' => 'dtNacimiento',
            'type' => 'date',
            'value' => $value,
        );
        echo form_label('Fecha de Nacimiento ', 'dtNacimiento');
        echo form_input($atributos);
        ?>
    </div>
    <br>

    <div id="boton">
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
<br>

<div id="cancelar">
    <?php
    echo form_open(RUTA_ADMINISTRACION . '/empleados/listado/volver', array('id' => 'btnCancelar', 'method' => 'post'));
    $submit_attributes = array(
        'name' => 'btSubmit',
        'id' => 'btSubmit',
        'class' => 'boton',
        'value' => 'Cancelar'
    );
    echo form_submit($submit_attributes);
    echo form_close();
    ?>
</div>


</body>
</html>