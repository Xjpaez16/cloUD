<?php

require_once('UsuarioDTO.php');

class EstudianteDTO extends UsuarioDTO
{
    private $cod_carrera;

    public function __construct($cod_carrera)
    {
        $this->cod_carrera = $cod_carrera;
    }

    public function getCod_carrera()
    {
        return $this->cod_carrera;
    }

    public function setCod_carrera($cod_carrera)
    {
        $this->cod_carrera = $cod_carrera;
        return $this;
    }
}