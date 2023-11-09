<?php

$this->table->set_heading('Nombre', 'Marca', 'Categoria', 'Cantidad', 'Precio');
$template = array(
	'table_open' => '<table style="border: 1px solid black; text-align: center">',
	'heading_cell_start' => '<th style="border: 1px solid black;">',
	'cell_start' => '<td style="border: 1px solid black;">',
	'cell_alt_start' => '<td style="border: 1px solid black;">',
);

$this->table->set_template($template);

echo $this->table->generate($productos);
echo $links;
