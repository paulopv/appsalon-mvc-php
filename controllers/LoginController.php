<?php

namespace Controllers;


use Classes\Email;
use MVC\Router;
use Model\Usuario;


class LoginController{
    public static function login(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();
          
            if(empty($alertas)){
                //verificar que el usuario exista
                $usuario = Usuario::where('email', $auth->email);
                if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                if($usuario){
                    //verificar password
                   
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        
                        //autenticar al usuario
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        //redireccionamiento
                        
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        }else{
                            header('Location: /cita');
                        }
                        debuguear($_SESSION);
                    } 
                }else{
                    Usuario::setAlerta('error', 'El Usuario no existe');
                }
            }
            
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login',[
            'alertas' => $alertas
        ]);
    }
     public static function logout(Router $router){
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
    public static function olvide(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            
            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                if($usuario&& $usuario->confirmado === "1"){
                    //generar un Token
                    $usuario->crearToken();
                    $usuario->guardar();
                    
                    
                    $email = new Email($usuario->email,$usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    //Alerta de exito
                    Usuario::setAlerta('exito', 'Revisa tu Email');

                    
                }else{
                    Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');
                    
                }
            }

        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password',[
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router){
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);
        //buscar el usuario por token
        $usuario = Usuario::where('token', $token);
        if(!$usuario){
            //mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //leer el nuevo password
            $password = new Usuario($_POST);
            //validar password
            $alertas = $password->validarPassword();
            
            if(empty($alertas)){
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado = $usuario->guardar();
                if($resultado){
                    //redireccionar al login
                    header('Location: /');
                    Usuario::setAlerta('exito', 'Password actualizado correctamente');
                }   
            }
        }

        $alertas = Usuario::getAlertas(); 

        $router->render('auth/recuperar-password',[
            'alertas' => $alertas,
            'error' => $error,
        ]);
    }
     public static function crear(Router $router){

        $usuario = new Usuario;
        //alertas vacias
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            
            //revisar que alertas este vacio
            if(empty($alertas)){
             //verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                }else{
                    //hashear el password
                    $usuario->hashPassword();

                    //generar un token
                    $usuario->crearToken();
                    $usuario->token = trim($usuario->token);

                    //enviar el email de confirmacion
                    $email = new Email( $usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();
                    //crear el usuario
                    
                    $resultado = $usuario->guardar();;
                    if($resultado){
                        header('Location: /mensaje');
                    }
                   
                    //debuguear($usuario);
                }
            }
        }    
         //siempre renderizar la vista   
       $router->render('auth/crear-cuenta',[
            'usuario' => $usuario,
            'alertas' => $alertas
       ]);    
    }
    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){
        $alertas = [];
        
        $token = s(trim($_GET['token']));
        
        $usuario = Usuario::where('token', $token);
        if(!$usuario){
            //Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no valido');

        }else{
            
           $usuario->confirmado = "1";
           $usuario->token = null;
           $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }
        //obtener las alertas
        $alertas = Usuario::getAlertas();
        //renderizar la vista
        $router->render('auth/confirmar-cuenta',[
            'alertas' => $alertas
        ]);
    }
}
