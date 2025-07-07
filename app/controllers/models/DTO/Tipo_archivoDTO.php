<?php

class Tipo_archivoDTO
{
    private $id;
    private $tipo;

    public function __construct($tipo = null, $id = null)
    {
        $this->id = $id;
        $this->tipo = $tipo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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
}