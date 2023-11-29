<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Listado privado vehiculos</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
</head>
<body>
<div id="titulo">
    <h1>Talleres Guzmán S.L. - Zona privada</h1>
    <h2>Listado de reservas</h2>
</div>

<div id="filtros">

    <?php
    echo form_open(RUTA_ADMINISTRACION . '/reservas/buscar', 'post');


    echo form_hidden('order_by', $filtros['ORDER_BY']);
    echo form_hidden('order_dir', $filtros['ORDER_DIR']);


    echo form_label(' Marca ', 'selMarca');

    $value = '';
    if(!empty($filtros['MARCA'])) $value = $filtros['MARCA'];
    if(!empty(validation_errors())) $value = set_value('selMarca');
    echo form_dropdown('selMarca', $marcas, $value);
    echo form_error('selMarca', '<span style=color:red>', ' </span>');


    echo form_error('selMarca', '<span style=color:red>', ' </span>');


    echo form_label('Modelo ', 'txModelo');
    $value = '';
    if(!empty($filtros['MODELO'])) $value = $filtros['MODELO'];
    if(!empty(validation_errors())) $value = set_value('txModelo');
    $modelo_attributes = array(
        'name' => 'txModelo',
        'id' => 'txModelo',
        'class' => 'input',
        'value' => $value
    );
    echo form_input($modelo_attributes);
    echo form_error('txModelo', '<span style=color:red>', ' </span>');


    echo form_label('Matrícula ', 'txMatricula');

    $value = '';
    if(!empty($filtros['MATRICULA'])) $value = $filtros['MATRICULA'];
    if(!empty(validation_errors())) $value = set_value('txMatricula');
    $matricula_attributes = array(
        'name' => 'txMatricula',
        'id' => 'txMatricula',
        'class' => 'input',
        'value' => $value,
    );
    echo form_input($matricula_attributes);
    echo form_error('txMatricula', '<span style=color:red>', ' </span>');


    echo form_label('Ubicacion ', 'txUbicacion');

    $value = '';
    if(!empty($filtros['UBICACION'])) $value = $filtros['UBICACION'];
    if(!empty(validation_errors())) $value = set_value('txUbicacion');
    $matricula_attributes = array(
        'name' => 'txUbicacion',
        'id' => 'txUbicacion',
        'class' => 'input',
        'value' => $value,
    );
    echo form_input($matricula_attributes);
    echo form_error('txUbicacion', '<span style=color:red>', ' </span>');

    echo '<br>';
    echo '<br>';

    echo form_label('Empleado ', 'txEmpleado');

    $value = '';
    if (!empty($filtros['EMPLEADO'])) $value = $filtros['EMPLEADO'];
    if (!empty(validation_errors())) $value = set_value('txEmpleado');
    $empleado_attributes = array(
        'name' => 'txEmpleado',
        'id' => 'txEmpleado',
        'class' => 'input',
        'value' => $value,
    );
    echo form_input($empleado_attributes);
    echo form_error('txEmpleado', '<span style=color:red>', ' </span>');


    echo form_label('Estado ', 'selEstado');

    $value = '';
    if(!empty($filtros['ESTADO'])) $value = $filtros['ESTADO'];
    if(!empty(validation_errors())) $value = set_value('selEstado');
    echo form_dropdown('selEstado', $estados, $value);
    echo form_error('selEstado', '<span style=color:red>', ' </span>');


    echo '<br>';
    echo '<br>';

    if (isset($validation_errors['fecha'])) echo '<p style="color: red">' . $validation_errors['fecha'] . '</p>';
    echo form_label('Desde ', 'dtDesde');

    $value = '';
    if(!empty($filtros['DESDE'])) $value = $filtros['DESDE'];
    if(!empty(validation_errors()) || !empty($validation_errors['fecha'])) $value = set_value('dtDesde');
    $atributos = array(
        'name' => 'dtDesde',
        'id' => 'dtDesde',
        'type' => 'datetime-local',
        'value' => $value,
    );
    echo form_input($atributos);
    echo form_error('dtDesde', '<span style=color:red>', ' </span>');


    echo form_label('Hasta ', 'dtHasta');

    $value = '';
    if(!empty($filtros['HASTA'])) $value = $filtros['HASTA'];
    if(!empty(validation_errors()) || !empty($validation_errors['fecha'])) $value = set_value('dtHasta');
    $atributos = array(
        'name' => 'dtHasta',
        'id' => 'dtHasta',
        'type' => 'datetime-local',
        'value' => $value,
    );
    echo form_input($atributos);
    echo form_error('dtHasta', '<span style=color:red>', '</span>');

    $submit_attributes = array(
        'name' => 'btSubmit',
        'id' => 'btSubmit',
        'class' => 'submit',
        'value' => 'Buscar'
    );
    echo form_submit($submit_attributes);
    ?>

    <button type="button" onclick="window.location.href='<?=site_url(RUTA_ADMINISTRACION . '/reservas/resetear')?>'">Resetear filtros</button>

    <?php echo form_close();
    ?>
</div>
<br>

<div id="tabla">
    <?php
    if($paginacion['TOTAL'] === 0): echo 'No hay reservas que mostrar';
    else:
        $this->table->set_heading($headers);

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
</div>
<br>
<div id="links">
    <?php
    $links = $this->pagination->create_links();
    echo $links;
    ?>
    <br>
    <?php
    if (count($reservas) === 0):
        echo '';
    else:
        if (count($reservas) !== 1):
            echo "Mostrando reservas ";
            echo $paginacion['TOTAL_PAGINAS'] === 0 ? '0' : (int)$paginacion['OFFSET'] + 1;
            echo " al ";
            echo min($paginacion['LIMIT'] + $paginacion['OFFSET_PAGINA'], $paginacion['TOTAL']);
        else:
            echo "Mostrando reserva " . ($paginacion['OFFSET'] + 1);
        endif;
        echo " de " . $paginacion['TOTAL'] . " reservas totales";
    endif;
    ?>
</div>
<br>

<div id="dropdown">
    <?php
    echo form_open(RUTA_ADMINISTRACION . '/reservas/listado/', array('id' => 'miFormulario', 'method' => 'post'));
    echo form_dropdown_num_records('productos_por_pagina', $paginacion['LIMIT'], 'miFormulario');
    echo form_close();
    ?>
</div>

<br>
<br>
<div id="Volver">
    <?php
    echo form_open(RUTA_ADMINISTRACION, array('id' => 'btnCancelar', 'method' => 'get'));
    $submit_attributes = array(
        'name' => 'btSubmit',
        'id' => 'btSubmit',
        'class' => 'boton',
        'value' => 'Volver'
    );
    echo form_submit($submit_attributes);
    echo form_close();
    ?>
</div>


<script>
    function ordenar(campo) {
        let order = 'ASC';
        let current_order_dir = document.getElementsByName('order_dir')[0].value;
        let current_order_value = document.getElementsByName('order_by')[0].value;
        if (current_order_value === campo) {
            if (current_order_dir === 'ASC') order = 'DESC';
        }
        document.getElementsByName('order_dir')[0].value = order;
        document.getElementsByName('order_by')[0].value = campo;
        document.forms[0].submit();
    }
</script>
</body>
</html>