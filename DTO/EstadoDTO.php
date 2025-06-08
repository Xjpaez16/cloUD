<?php

class EstadoDTO
{
    public $codigo;
    public $tipo_estado;

    public function __construct($codigo, $tipo_estado)
    {
        $this->codigo = $codigo;
        $this->tipo_estado = $tipo_estado;
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

    public function getTipo_estado()
    {
        return $this->tipo_estado;
    }

    public function setTipo_estado($tipo_estado)
    {
        $this->tipo_estado = $tipo_estado;
        return $this;
    }
}