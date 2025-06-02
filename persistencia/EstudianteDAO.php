<?php
class EstudianteDAO {
    private $id;
    private $nombre;
    private $correo;
    private $telefono;
    private $clave;
    
    public function __construct($id = "", $nombre = "", $correo = "", $telefono = "", $clave = ""){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->telefono = $telefono;
        $this->clave = $clave;
    }
    
    public function autenticar(){
        return "SELECT id_estudiante
                FROM Estudiante
                WHERE correo = '" . $this->correo . "'
                AND clave = '" . md5($this->clave) . "'";
    }
    
    public function consultar(){
        return "SELECT nombre, correo, telefono
                FROM Estudiante
                WHERE id_estudiante = '" . $this->id . "'";
    }
}
?>