<h1 class="nombre-pagina">Olvide password</h1>
<p class="descripcion-pagina">Reestablece tu password escribiendo tu Email a continuacion.</p>

<?php 
    include_once __DIR__ . '/../templ/alertas.php';
?>
<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="email">Email</label>
        <input 
        type="email"
        id="email"
        name="email"
        placeholder="Tu Email"
        
        />
    </div>
    <input type="submit" class="boton" value="Enviar instrucciones"/>
</form>
<div class="acciones">
    <a href="/">Ya tienes una cuenta?  Inicia Sesion</a>
    <a href="/crear-cuenta">Aun no tienes una cuenta?  Crear Cuenta</a>
</div>


