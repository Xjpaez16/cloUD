<?php

class MotivoDTO
{
    private $codigo;
    private $tipo_motivo;

    public function __construct($codigo = null, $tipo_motivo = null)
    {
        $this->codigo = $codigo;
        $this->tipo_motivo = $tipo_motivo;
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

    public function getTipo_motivo()
    {
        return $this->tipo_motivo;
    }

    public function setTipo_motivo($tipo_motivo)
    {
        $this->tipo_motivo = $tipo_motivo;
        return $this;
    }
}