<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Bienvenida zona privada</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
</head>
<body>
    <div id="titulo">
        <h1>Talleres Guzmán S.L. - Zona privada</h1>
    </div>
	<p>Bienvenid@&nbsp;<?=$administrador['NOMBRE']?>!!</p>
	<span>Has iniciado sesión en la zona privada.</span>
	<br>
	<br>
    <button onclick="window.location.href='<?=site_url(RUTA_ADMINISTRACION . '/empleados/listado')?>'">Empleados</button>
    <br>
    <br>
    <button onclick="window.location.href='<?=site_url(RUTA_ADMINISTRACION . '/vehiculos/listado')?>'">Vehículos</button>
    <br>
    <br>
    <button onclick="window.location.href='<?=site_url(RUTA_ADMINISTRACION . '/reservas/listado')?>'">Gestión de reservas</button>
    <br>
    <br>
    <br>
	<button onclick="window.location.href='<?=site_url(RUTA_ADMINISTRACION . '/administrador/logout')?>'">Cerrar sesión</button>
</body>
</html>
