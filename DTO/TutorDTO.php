<?php

require_once('UsuarioDTO.php');

class TutorDTO extends UsuarioDTO
{
    public $calificacion_general;

    public function __construct($calificacion_general)
    {
        $this->calificacion_general = $calificacion_general;
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
}