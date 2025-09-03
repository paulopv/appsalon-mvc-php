<?php

namespace Controllers;
use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{
    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);
        // debuguear($servicios);
    }
    public static function guardar(){
        //almaena la cita y devuelve Id
       $cita = new Cita($_POST);
       $resultado = $cita->guardar();
       $id = $resultado['id'];

        //Almacena la cita y los servicios
        //almacena los servicioscon el ID de la cita
        $idServicios = explode(",", $_POST['servicios']);
        
        foreach($idServicios as $idServicio){
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
         
            
        }
      
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar(){
    
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $db = Cita::getDB();
            $db->query("DELETE FROM citasservicios WHERE citaId = {$id}");
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:'.$_SERVER['HTTP_REFERER']);
        }
    }

}
