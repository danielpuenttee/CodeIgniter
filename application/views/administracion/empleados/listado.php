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
    <h2>Listado de empleados</h2>
</div>

<div id="filtros">
    <?php
    echo form_open('zona_privada/empleados/buscar', 'post');

    echo form_hidden('order_by', $filtros['ORDER_BY']);
    echo form_hidden('order_dir', $filtros['ORDER_DIR']);


    echo form_error('txIdentificador', '<p style=color:red>', '</p>');
    echo form_label('Identificador ', 'txIdentificador');

    $value = '';
    if(!empty($filtros['IDENTIFICADOR'])) $value = $filtros['IDENTIFICADOR'];
    if(!empty(validation_errors())) $value = set_value('txIdentificador');
    $modelo_attributes = array(
        'name' => 'txIdentificador',
        'id' => 'txIdentificador',
        'class' => 'input',
        'value' => $value
    );
    echo form_input($modelo_attributes);


    echo form_error('txNombre', '<p style=color:red>', '</p>');
    echo form_label('Nombre ', 'txNombre');

    $value = '';
    if(!empty($filtros['NOMBRE'])) $value = $filtros['NOMBRE'];
    if(!empty(validation_errors())) $value = set_value('txNombre');
    $modelo_attributes = array(
        'name' => 'txNombre',
        'id' => 'txNombre',
        'class' => 'input',
        'value' => $value
    );
    echo form_input($modelo_attributes);


    echo form_error('txApellidos', '<p style=color:red>', '</p>');
    echo form_label('Apellidos ', 'txApellidos');

    $value = '';
    if(!empty($filtros['APELLIDOS'])) $value = $filtros['APELLIDOS'];
    if(!empty(validation_errors())) $value = set_value('txApellidos');
    $matricula_attributes = array(
        'name' => 'txApellidos',
        'id' => 'txApellidos',
        'class' => 'input',
        'value' => $value,
    );
    echo form_input($matricula_attributes);


    echo form_label('Nacido en: ', 'intAno');

    $value = '';
    if (!empty($filtros['FECHA_NACIMIENTO'])) $value = $filtros['FECHA_NACIMIENTO'];
    elseif (!empty(validation_errors())) $value = set_value('intAno');
    $ano_attributes = array(
        'name' => 'intAno',
        'id' => 'intAno',
        'class' => 'input',
        'type' => 'number',
        'step' => '1',
        'value' => $value,
    );

    echo form_input($ano_attributes);
    echo form_error('intAno', '<span style=color:red>', ' </span>');


    $submit_attributes = array(
        'name' => 'btSubmit',
        'id' => 'btSubmit',
        'class' => 'boton',
        'value' => 'Buscar'
    );
    echo form_submit($submit_attributes);
    ?>
    <button type="button" onclick="window.location.href='<?=site_url(RUTA_ADMINISTRACION . '/empleados/resetear')?>//'">Resetear filtros</button>
    <?php echo form_close();?>
</div>
<br>

<div id="tabla">
    <?php
    if($paginacion['TOTAL'] === 0): echo 'No hay empleados que mostrar';
    else:
        $identificador = 'Identificador' . ($filtros['ORDER_BY'] === 'IDENTIFICADOR' ? $filtros['ORDER_DIR'] === 'ASC' ? '&#8593' : '&#8595' : '&#8593&#8595');
        $nombre = 'Nombre' . ($filtros['ORDER_BY'] === 'NOMBRE' ? $filtros['ORDER_DIR'] === 'ASC' ? '&#8593' : '&#8595' : '&#8593&#8595');
        $apellidos = 'Apellidos' . ($filtros['ORDER_BY'] === 'APELLIDOS' ? $filtros['ORDER_DIR'] === 'ASC' ? '&#8593' : '&#8595' : '&#8593&#8595');
        $fecha = 'Fecha nacimiento' . ($filtros['ORDER_BY'] === 'FECHA_NACIMIENTO' ? $filtros['ORDER_DIR'] === 'ASC' ? '&#8593' : '&#8595' : '&#8593&#8595');

        $this->table->set_heading(
            '<span onclick="ordenar(\'IDENTIFICADOR\')">' . $identificador . '</span>',
            '<span onclick="ordenar(\'NOMBRE\')">' . $nombre . '</span>',
            '<span onclick="ordenar(\'APELLIDOS\')">' . $apellidos . '</span>',
            '<span onclick="ordenar(\'FECHA_NACIMIENTO\')">' . $fecha . '</span>'
        );

        $template = array(
            'table_open' => '<table style="border: 3px solid black; text-align: center">',
            'heading_cell_start' => '<th style="border: 2px solid black">',
            'cell_start' => '<td style="border: 1px solid black;">',
            'cell_alt_start' => '<td style="border: 1px solid black;">'
        );
        $this->table->set_template($template);

        echo $this->table->generate($empleados);
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
    <br>
    <?php
    if (count($empleados) === 0):
        echo '';
    else:
        if (count($empleados) !== 1):
            echo "Mostrando empleados ";
            echo $paginacion['TOTAL_PAGINAS'] === 0 ? '0' : (int)$paginacion['OFFSET'] + 1;
            echo " al ";
            echo min($paginacion['LIMIT'] + $paginacion['OFFSET_PAGINA'], $paginacion['TOTAL']);
        else:
            echo "Mostrando empleado " . ($paginacion['OFFSET'] + 1);
        endif;
        echo " de " . $paginacion['TOTAL'] . " empleados totales";
    endif;
    ?>
</div>

<div id="dropdown">
    <?php
    echo form_open(RUTA_ADMINISTRACION . '/empleados/listado/', array('id' => 'miFormulario', 'method' => 'post'));
    echo form_dropdown_num_records('productos_por_pagina', $paginacion['LIMIT'], 'miFormulario');
    echo form_close();
    ?>
</div>
<br>
<br>
<div id="nuevo_empleado">
    <?php
    echo form_open(RUTA_ADMINISTRACION . '/empleados/ficha/0');
    echo form_submit('', 'Nuevo empleado');
    echo form_close();
    ?>
</div>
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


















