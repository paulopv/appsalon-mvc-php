<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administracion de Servicios</p>
<?php
include_once __DIR__ . '/../templ/barra.php';

?>

<ul class="servicios">
    <?php foreach($servicios as $servicio){?>

        <li>
            <p>Nombre: <span><?php echo $servicio->nombre;?> </span></p>
            <p>Precio: $<span><?php echo $servicio->precio;?></span></p>
            <dic class="acciones">
                <a class="boton" href="/servicios/actualizar?id=<?php echo $servicio->id ?>">Actualizar</a>
                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id?>">
                    <input type="submit" class="boton-eliminar" value="Borrar">
                </form>
                
            </dic>
        </li>
        <?php }?>
</ul>
