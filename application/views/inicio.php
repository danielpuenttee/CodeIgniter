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

<div id="tabla">
    <?php
    if($paginacion['TOTAL'] === 0): echo 'No hay pedidos que mostrar';
    else:
        $this->table->set_heading('Matricula', 'Marca', 'Modelo', 'Ubicación');

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
        echo 'No hay productos que mostrar';
    else:
        if (count($vehiculos) !== 1):
            echo "Mostrando vehiculos ";
            echo $paginacion['TOTAL_PAGINAS'] === 0 ? '0' : (int)$paginacion['OFFSET'] + 1;
            echo " al ";
            echo $paginacion['LIMIT'] + $paginacion['OFFSET_PAGINA'] < $paginacion['TOTAL'] ?
                $paginacion['LIMIT'] + $paginacion['OFFSET_PAGINA'] : $paginacion['TOTAL'];
        else:
            echo "Mostrando vehiculo " . $paginacion['OFFSET'] + 1;
        endif;
        echo " de " . $paginacion['TOTAL'] . " vehiculos totales";
    endif;
    ?>
</div>


<div>
	<h3>Acceso zona privada</h3>
	<p>Haga click <a href="<?=site_url(RUTA_ADMINISTRACION)?>">aquí</a> para acceder a la zona privada</p>
</div>
</body>
</html>
