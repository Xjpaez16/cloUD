<?php

class S3DTO
{
    private $nombre;
    private $tipo;
    private $tamaño;
    private $url;

    public function __construct($nombre = null , $tipo = null, $tamaño = null, $url = null)
    {
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->tamaño = $tamaño;
        $this->url = $url;
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

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    public function getTamaño()
    {
        return $this->tamaño;
    }

    public function setTamaño($tamaño)
    {
        $this->tamaño = $tamaño;
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
}