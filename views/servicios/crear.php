<h1 class="nombre-pagina">Nuevo Servicio</h1>
<p class="descripcion-pagina">llena todos los campos para incluirun nuevo Servicios</p>
<?php
include_once __DIR__ . '/../templ/barra.php';
include_once __DIR__ . '/../templ/alertas.php';
?>

<form class="formulario" method="POST" action="/servicios/crear">
    <?php include_once __DIR__ . '/formulario.php'; ?>

    <input type="submit" class="boton" value="Guardar Servicio">
</form>