<?php

class UsuarioDTO
{
    public $codigo;
    public $nombre;
    public $correo;
    public $contrasena;
    public $respuesta_preg;

    public function __construct($codigo, $nombre, $correo, $contrasena, $respuesta_preg)
    {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
        $this->respuesta_preg = $respuesta_preg;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
        return $this;
    }

    public function getContrasena()
    {
        return $this->contrasena;
    }

    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;
        return $this;
    }

    public function getRespuesta_preg()
    {
        return $this->respuesta_preg;
    }

    public function setRespuesta_preg($respuesta_preg)
    {
        $this->respuesta_preg = $respuesta_preg;
        return $this;
    }
}