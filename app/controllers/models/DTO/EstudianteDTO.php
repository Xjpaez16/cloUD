<?php

require_once('UsuarioDTO.php');

class EstudianteDTO extends UsuarioDTO
{
    private $cod_carrera;
    private $cod_estado;

    public function __construct($codigo = null, $nombre = null, $correo = null, $contrasena = null, $respuesta_preg = null, $cod_carrera = null, $cod_estado = 2)
    {
        parent::__construct($codigo, $nombre, $correo, $contrasena, $respuesta_preg);
        $this->cod_carrera = $cod_carrera;
        $this->cod_estado = $cod_estado;
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

    public function getCod_estado()
    {
        return $this->cod_estado;
    }

    public function setCod_estado($cod_estado)
    {
        $this->cod_estado = $cod_estado;
        return $this;
    }
}