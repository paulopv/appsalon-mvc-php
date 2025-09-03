<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php
    include_once __DIR__ ."/../templ/alertas.php";
?>
<form action="/" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input
        type="email"
        id="email"
        placeholder="Tu Email"
        name="email"
       
        />
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input
        type="password"
        id="password"
        placeholder="Tu Password"
        name="password"
        
        />
    </div>
    <input type="submit" class="boton" value="Iniciar Sesion" />
</form>

<div class="acciones">
    <a href="/crear-cuenta">Aun no tienes una cuenta?  Crear Cuenta</a>
    <a href="/olvide"> Olvidaste tu password?</a>
</div>