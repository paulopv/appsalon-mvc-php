<h1 class="nombre-pagina">Actualizar Servicios</h1>
<p class="descripcion-pagina">Modifica los valores de formulario</p>
<?php
include_once __DIR__ . '/../templ/barra.php';
include_once __DIR__ . '/../templ/alertas.php';
?>

<form class="formulario" method="POST" >
    <?php include_once __DIR__ . '/formulario.php'; ?>

    <input type="submit" class="boton" value="Actualizar">
</form>
