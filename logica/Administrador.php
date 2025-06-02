<?php
require_once("persistencia/Conexion.php");
require_once("logica/Persona.php");
require_once("persistencia/AdministradorDAO.php");

class Administrador extends Persona {
    
    public function __construct($id = "", $nombre = "", $correo = "", $telefono = "", $clave = ""){
        parent::__construct($id, $nombre, $correo, $telefono, $clave);
    }
    
    public function autenticar(){
        $conexion = new Conexion();
        $administradorDAO = new AdministradorDAO("", "", $this->correo, "", $this->clave);
        $conexion->abrir();
        $conexion->ejecutar($administradorDAO->autenticar());
        
        if($conexion->filas() == 1){
            $resultado = $conexion->registro();
            $this->id = $resultado[0];
            $this->consultar(); // Cargar los demás datos del administrador
            $conexion->cerrar();
            return true;
        }else{
            $conexion->cerrar();
            return false;
        }
    }
    
    public function consultar(){
        $conexion = new Conexion();
        $administradorDAO = new AdministradorDAO($this->id);
        $conexion->abrir();
        $conexion->ejecutar($administradorDAO->consultar());
        
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