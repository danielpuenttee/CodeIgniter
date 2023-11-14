<h1>Ejercicio 3</h1>

<?php

if($paginacion['TOTAL'] === 0) echo 'No hay pedidos que mostrar';
else {
	$this->table->set_heading('Nombre', 'Marca', 'Categoria', 'Cantidad', 'Precio');
	$template = array(
		'table_open' => '<table style="border: 3px solid black; text-align: center">',
		'heading_cell_start' => '<th style="border: 2px solid black;">',
		'cell_start' => '<td style="border: 1px solid black;">',
		'cell_alt_start' => '<td style="border: 1px solid black;">',
	);

	$this->table->set_template($template);

	echo $this->table->generate($productos);

	echo $links . '<br>' . '<br>';

	if ($paginacion['TOTAL'] === 0):
		echo 'No hay pedidos que mostrar';
	else:
		if ($paginacion['TOTAL'] !== 1):
			echo "Mostrando pedidos ";
			echo $paginacion['TOTAL_PAGINAS'] === 0 ? '0' : (int)$paginacion['OFFSET'] + 1;
			echo " a ";
			echo $paginacion['LIMIT'] + $paginacion['OFFSET'] < $paginacion['TOTAL'] ?
				$paginacion['LIMIT'] + $paginacion['OFFSET'] : $paginacion['TOTAL'];
		else:
			echo "Mostrando pedido " . $paginacion['OFFSET'] + 1;
		endif;
		echo " de " . $paginacion['TOTAL'] . " pedidos totales";
	endif;
}
