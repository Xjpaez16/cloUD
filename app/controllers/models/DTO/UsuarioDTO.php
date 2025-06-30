<?php

class UsuarioDTO
{
    protected $codigo;
    protected $nombre;
    protected $correo;
    protected $contrasena;
    protected $respuesta_preg;
    protected $activo;
    
    public function __construct($codigo, $nombre, $correo, $contrasena, $respuesta_preg, $activo = 1)
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

    public function getActivo() { return $this->activo; }
    public function setActivo($activo) { $this->activo = $activo; return $this; }
}