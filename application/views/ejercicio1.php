<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Ejercicio 1</title>
</head>

<body>
<div id="ejercicio1">

	<h1>Ejercicio 1</h1>

	<div id="ap1">
		<h2>Apartado 1</h2>
		<table class="table" style="text-align: center">
			<thead>
			<th style="display: none">ID</th>
			<th>Nombre</th>
			<th>Marca</th>
			<th>Categoria ID</th>
			<th>Cantidad</th>
			<th>Precio</th>
			</thead>

			<tbody>
			<?php foreach ($apartado1 as $key => $producto) : ?>
				<tr>
					<td style="display: none"> <?= $producto['PK_ID_PRODUCTO'] ?> </td>
					<td><?= $producto['NOMBRE'] ?></td>
					<td><?= $producto['MARCA'] ?></td>
					<td><?= $producto['FK_ID_CATEGORIA'] ?></td>
					<td><?= $producto['CANTIDAD'] ?></td>
					<td><?= $producto['PRECIO'] ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

	</div>

	<div id="ap2">
		<h2>Apartado 2</h2>
		<table class="table" style="text-align: center">
			<thead>
			<th style="display: none">ID</th>
			<th>Nombre</th>
			</thead>

			<tbody>
			<?php foreach ($apartado2 as $key => $categoria) : ?>
				<tr>
					<td style="display: none"> <?= $categoria['PK_ID_CATEGORIA'] ?> </td>
					<td><?= $categoria['NOMBRE'] ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<div id="ap3">
		<h2>Apartado 3</h2>
		<table class="table" style="text-align: center">
			<thead>
			<th style="display: none">ID</th>
			<th>Nombre</th>
			<th>Marca</th>
			<th>Categoria</th>
			<th>Cantidad</th>
			<th>Precio</th>
			</thead>

			<tbody>
			<?php foreach ($apartado3 as $key => $producto) : ?>
				<tr>
					<td style="display: none"> <?= $producto['PK_ID_PRODUCTO'] ?> </td>
					<td><?= $producto['NOMBRE'] ?></td>
					<td><?= $producto['MARCA'] ?></td>
					<td><?= $producto['NOMBRE_CAT'] ?></td>
					<td><?= $producto['CANTIDAD'] ?></td>
					<td><?= $producto['PRECIO'] ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<div id="ap4">
		<h2>Apartado 4</h2>
		<table class="table" style="text-align: center">
			<thead>
			<th style="display: none">ID</th>
			<th>Nombre</th>
			<th>Marca</th>
			<th>Categoria</th>
			<th>Cantidad</th>
			<th>Precio</th>
			</thead>

			<tbody>
			<?php foreach ($apartado4 as $key => $producto) : ?>
				<tr>
					<td style="display: none"> <?= $producto['PK_ID_PRODUCTO'] ?> </td>
					<td><?= $producto['NOMBRE'] ?></td>
					<td><?= $producto['MARCA'] ?></td>
					<td><?= $producto['NOMBRE_CAT'] ?></td>
					<td><?= $producto['CANTIDAD'] ?></td>
					<td><?= $producto['PRECIO'] ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<div id="ap5">
		<h2>Apartado 5</h2>
		<table class="table" style="text-align: center">
			<thead>
			<th style="display: none">ID</th>
			<th>Nombre</th>
			<th>Marca</th>
			<th>Categoria</th>
			<th>Cantidad</th>
			<th>Precio</th>
			</thead>

			<tbody>
			<?php foreach ($apartado5 as $key => $producto) : ?>
				<tr>
					<td style="display: none"> <?= $producto['PK_ID_PRODUCTO'] ?> </td>
					<td><?= $producto['NOMBRE'] ?></td>
					<td><?= $producto['MARCA'] ?></td>
					<td><?= $producto['NOMBRE_CAT'] ?></td>
					<td><?= $producto['CANTIDAD'] ?></td>
					<td><?= $producto['PRECIO'] ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<div id="ap6">
		<h2>Apartado 6</h2>
		<strong>Media de precios: </strong> <?= round($apartado6[0]['PRECIO'], 2) . ' €' ?>
	</div>

	<div id="ap7">
		<h2>Apartado 7</h2>
		<table class="table" style="text-align: center">
			<thead>
			<th>Categoria</th>
			<th>Número de productos</th>
			</thead>

			<tbody>
			<?php foreach ($apartado7 as $key => $producto) : ?>
				<tr>
					<td><?= $producto['NOMBRE'] ?></td>
					<td><?= $producto['NUMERO_PRODUCTOS'] ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<div id="ap8">
		<h2>Apartado 8</h2>
		<?php if (count($apartado8) === 0): ?>
			<p>No hay productos!</p>
		<?php else: ?>
		<table class="table" style="text-align: center">
			<thead>
			<th>Categoria</th>
			<th>Número de productos</th>
			</thead>

			<tbody>
			<?php foreach ($apartado8 as $key => $producto) : ?>
				<tr>
					<td><?= $producto['NOMBRE'] ?></td>
					<td><?= $producto['NUMERO_PRODUCTOS'] ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
	</div>


	<div id="ap9">
		<h2>Apartado 9</h2>
		<p>Los pedidos:</p>
		<table class="table" style="text-align: center">
			<thead>
			<th>Nombre</th>
			<th>Marca</th>
			<th>Categoria ID</th>
			<th>Cantidad</th>
			<th>Precio</th>
			</thead>

			<tbody>
			<?php foreach ($apartado9 as $key => $producto) : ?>
				<tr>
					<td><?= $producto['NOMBRE'] ?></td>
					<td><?= $producto['MARCA'] ?></td>
					<td><?= $producto['FK_ID_CATEGORIA'] ?></td>
					<td><?= $producto['CANTIDAD'] ?></td>
					<td><?= $producto['PRECIO'] ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<p>han sido creados e insertados en la base de datos.</p>
	</div>


	<div id="ap10">
		<h2>Apartado 10</h2>
		<p>El pedido con id <?= $apartado10['NUEVO']['PK_ID_PRODUCTO'] ?> ha sido modificado:</p>
		<table class="table" style="text-align: center">
			<thead>
			<th></th>
			<th>Nombre</th>
			<th>Marca</th>
			<th>Categoria ID</th>
			<th>Cantidad</th>
			<th>Precio</th>
			</thead>

			<tbody>
			<?php foreach ($apartado10 as $key => $producto) : ?>
				<tr>
					<td><?= $key ?></td>
					<td><?= $producto['NOMBRE'] ?></td>
					<td><?= $producto['MARCA'] ?></td>
					<td><?= $producto['FK_ID_CATEGORIA'] ?></td>
					<td><?= $producto['CANTIDAD'] ?></td>
					<td><?= $producto['PRECIO'] ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>



	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
