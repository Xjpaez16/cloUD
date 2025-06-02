<?php
require_once("persistencia/Conexion.php");
require_once("logica/Persona.php");
require_once("persistencia/TutorDAO.php");

class Tutor extends Persona {
    
    public function __construct($id = "", $nombre = "", $correo = "", $telefono = "", $clave = ""){
        parent::__construct($id, $nombre, $correo, $telefono, $clave);
    }
    
    public function autenticar(){
        $conexion = new Conexion();
        $tutorDAO = new TutorDAO("", "", $this->correo, "", $this->clave);
        $conexion->abrir();
        $conexion->ejecutar($tutorDAO->autenticar());
        
        if($conexion->filas() == 1){
            $resultado = $conexion->registro();
            $this->id = $resultado[0];
            $this->consultar(); // Cargar los demás datos del tutor
            $conexion->cerrar();
            return true;
        }else{
            $conexion->cerrar();
            return false;
        }
    }
    
    public function consultar(){
        $conexion = new Conexion();
        $tutorDAO = new TutorDAO($this->id);
        $conexion->abrir();
        $conexion->ejecutar($tutorDAO->consultar());
        
        if($conexion->filas() > 0){
            $datos = $conexion->registro();
            $this->nombre = $datos[0];
            $this->correo = $datos[1];
            $this->telefono = $datos[2];
        }
        
        $conexion->cerrar();
    }
}
?>