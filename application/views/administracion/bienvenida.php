<!DOCTYPE html>
<html>
<head/>
<body>
	<h1>Plataforma - Zona privada</h1>
	<p>Bienvenid@&nbsp;<?=$administrador['NOMBRE']?>!!</p>
	<p>Has iniciado sesión en la zona privada.</p>
	<br/>
	<button onclick="window.location.href='<?=site_url(RUTA_ADMINISTRACION . '/vehiculos/listado')?>'">Vehículos</button>
	<br/>
	<br/>
	<button onclick="window.location.href='<?=site_url(RUTA_ADMINISTRACION . '/administrador/logout')?>'">Cerrar sesión</button>
</body>
</html>
