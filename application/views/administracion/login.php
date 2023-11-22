<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<title>Plataforma</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
</head>
<body>
	<h1>Plataforma - Zona privada</h1>
	<h3>Login</h3>
	<?php echo form_open(site_url('zona_privada/administrador/login'), array('class'=>'', 'name' => 'form_ficha', 'id' => 'form_ficha')); ?>
	<div class="div_login">
		<? // Errores de validación controlados en PHP (por Codeigniter o por nosotros (errores propios)) ?>
		<?php if(validation_errors()!=""){?>
			<div id="alertas_formulario_post">
				<span> <?php echo validation_errors() ?> </span>
			</div>
		<?}?>
		<?php
		if(isset($validation_errors) && count($validation_errors)>0){
			foreach($validation_errors as $error){?>
				<div id="alertas_formulario_post_manuales">
					<span> <?php echo $error ?> </span>
				</div>
			<?}
		}
		?>
		<? // Fin errores de validación controlados en PHP (por Codeigniter o por nosotros (errores propios)) ?>
		<div class="form-group">
			<input class="form-control" type="text" placeholder="Email" name="txUsername" value="<?=set_value('txUsername', '')?>" id="txUsername">
		</div>
		<div class="form-group">
			<input class="form-control" type="password" placeholder="Contraseña" name="txPassword" id="txPassword">
		</div>
		<div class="form-action">
			<button name="btAcceder" id="btAcceder" class="btn btn-focus" type="submit">Acceder</button>
		</div>
	</div>
	<? echo form_close();?>
</body>
</html>
