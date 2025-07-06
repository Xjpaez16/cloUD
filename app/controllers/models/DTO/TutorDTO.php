<?php

require_once('UsuarioDTO.php');

class TutorDTO extends UsuarioDTO
{
    private $calificacion_general;
    private $cod_estado;
    private $areas = [];

    public function __construct($codigo = null, $nombre = null, $correo = null, $contrasena = null, $calificacion_general = null, $respuesta_preg = null,  $cod_estado = 2)
    {
        parent::__construct($codigo, $nombre, $correo, $contrasena, $respuesta_preg);
        $this->calificacion_general = $calificacion_general;
        $this->cod_estado = $cod_estado;
    }

    public function getCalificacion_general()
    {
        return $this->calificacion_general;
    }

    public function setCalificacion_general($calificacion_general)
    {
        $this->calificacion_general = $calificacion_general;
        return $this;
    }

    public function getCod_estado()
    {
        return $this->cod_estado;
    }

    public function setCod_estado($cod_estado)
    {
        $this->cod_estado = $cod_estado;
        return $this;
    }

    public function getAreas()
    {
        return $this->areas;
    }

    public function setAreas($areas)
    {
        $this->areas = $areas;
        return $this;
    }

}
?>