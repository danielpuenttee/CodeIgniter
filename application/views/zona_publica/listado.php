<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Plataforma</title>
	<meta name="description" content="Latest updates and statistic charts">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
</head>
<body>
<div id="container">
	<h1>Talleres Guzmán S.L. - Listado de vehículos</h1>
</div>

<div id="filtros">

    <?php
        echo form_open('zona_publica/listado/buscar', 'post');

        echo form_hidden('order_by', $filtros['ORDER_BY']);
        echo form_hidden('order_dir', $filtros['ORDER_DIR']);

        echo form_error('selMarca', '<p style=color:red>', '</p>');
        echo form_label('Marca ', 'selMarca');

        $value = '';
        if(!empty($filtros['MARCA'])) $value = $filtros['MARCA'];
        if(!empty(validation_errors())) $value = set_value('selMarca');
        echo form_dropdown('selMarca', $marcas, $value);


        echo form_error('txModelo', '<p style=color:red>', '</p>');

        $value = '';
        if(!empty($filtros['MODELO'])) $value = $filtros['MODELO'];
        if(!empty(validation_errors())) $value = set_value('txModelo');
        $modelo_attributes = array(
            'name' => 'txModelo',
            'id' => 'txModelo',
            'class' => 'input',
            'value' => $value
        );
        echo form_label('Modelo ', 'txModelo');
        echo form_input($modelo_attributes);


        echo form_error('txMatricula', '<p style=color:red>', '</p>');

        $value = '';
        if(!empty($filtros['MATRICULA'])) $value = $filtros['MATRICULA'];
        if(!empty(validation_errors())) $value = set_value('txMatricula');
        $matricula_attributes = array(
            'name' => 'txMatricula',
            'id' => 'txMatricula',
            'class' => 'input',
            'value' => $value,
        );
        echo form_label('Matricula ', 'txMatricula');
        echo form_input($matricula_attributes);

        $submit_attributes = array(
            'name' => 'btSubmit',
            'id' => 'btSubmit',
            'class' => 'submit',
            'value' => 'Buscar'
        );
        echo form_submit($submit_attributes);
        echo form_close();
        echo form_close();
    ?>
</div>
<br>

<div id="tabla">
    <?php
    if($paginacion['TOTAL'] === 0): echo 'No hay vehiculos que mostrar';
    else:
        $marca = 'Marca' . ($filtros['ORDER_BY'] === 'MARCA' ? $filtros['ORDER_DIR'] === 'ASC' ? '&#8593' : '&#8595' : '&#8593&#8595');
        $modelo = 'Modelo' . ($filtros['ORDER_BY'] === 'MODELO' ? $filtros['ORDER_DIR'] === 'ASC' ? '&#8593' : '&#8595' : '&#8593&#8595');

        $this->table->set_heading(
            'Matricula',
            '<span onclick="ordenar(\'MARCA\')">' . $marca . '</span>',
            '<span onclick="ordenar(\'MODELO\')">' . $modelo . '</span>',
            'Ubicación');

        $template = array(
            'table_open' => '<table style="border: 3px solid black; text-align: center">',
            'heading_cell_start' => '<th style="border: 2px solid black">',
            'cell_start' => '<td style="border: 1px solid black;">',
            'cell_alt_start' => '<td style="border: 1px solid black;">'
        );
        $this->table->set_template($template);

        echo $this->table->generate($vehiculos);
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
    if (count($vehiculos) === 0):
        echo '';
    else:
        if (count($vehiculos) !== 1):
            echo "Mostrando vehiculos ";
            echo $paginacion['TOTAL_PAGINAS'] === 0 ? '0' : (int)$paginacion['OFFSET'] + 1;
            echo " al ";
            echo min($paginacion['LIMIT'] + $paginacion['OFFSET_PAGINA'], $paginacion['TOTAL']);
        else:
            echo "Mostrando vehiculo " . ($paginacion['OFFSET'] + 1);
        endif;
        echo " de " . $paginacion['TOTAL'] . " vehiculos totales";
    endif;
    ?>
</div>
<br>

<div id="dropdown">
    <?php
        echo form_open('zona_publica/listado/index/', array('id' => 'miFormulario', 'method' => 'post'));
        echo form_dropdown_num_records('productos_por_pagina', $paginacion['LIMIT'], 'miFormulario');
        echo form_close();
    ?>
</div>


<div id="zonaPrivada">
	<h3>Acceso zona privada</h3>
	<p>Haga click <a href="<?=site_url(RUTA_ADMINISTRACION)?>">aquí</a> para acceder a la zona privada</p>
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
