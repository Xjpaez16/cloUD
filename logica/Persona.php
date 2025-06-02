<?php
class Persona {
    protected $id;
    protected $nombre;
    protected $correo;
    protected $telefono;
    protected $clave;
    
    public function __construct($id = "", $nombre = "", $correo = "", $telefono = "", $clave = ""){
        $this -> id = $id;
        $this -> nombre = $nombre;
        $this -> correo = $correo;
        $this -> telefono = $telefono;
        $this -> clave = $clave;
    }
    
    public function getId(){
        return $this -> id;
    }
    
    public function getNombre(){
        return $this -> nombre;
    }
    
    public function getCorreo(){
        return $this -> correo;
    }
    
    public function getTelefono(){
        return $this -> telefono;
    }
    
    public function getClave(){
        return $this -> clave;
    }
    
    public function setId($id){
        $this -> id = $id;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setCorreo($correo) {
        $this->correo = $correo;
    }
    
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
    
    public function setClave($clave) {
        $this->clave = $clave;
    }
    
}
?>