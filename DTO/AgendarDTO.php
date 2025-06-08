<?php

class AgendarDTO
{
    private $cod_estudiante;
    private $cod_tutor;
    private $id;
    private $fecha;
    private $hora_inicio;
    private $hora_fin;
    private $cod_estado;
    private $cod_motivo;

    public function __construct($cod_estudiante, $cod_tutor, $id, $fecha, $hora_inicio, $hora_fin, $cod_estado, $cod_motivo)
    {
        $this->cod_estudiante = $cod_estudiante;
        $this->cod_tutor = $cod_tutor;
        $this->id = $id;
        $this->fecha = $fecha;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
        $this->cod_estado = $cod_estado;
        $this->cod_motivo = $cod_motivo;
    }

    public function getCod_estudiante()
    {
        return $this->cod_estudiante;
    }

    public function setCod_estudiante($cod_estudiante)
    {
        $this->cod_estudiante = $cod_estudiante;
        return $this;
    }

    public function getCod_tutor()
    {
        return $this->cod_tutor;
    }

    public function setCod_tutor($cod_tutor)
    {
        $this->cod_tutor = $cod_tutor;
        return $this;
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

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    public function getHora_inicio()
    {
        return $this->hora_inicio;
    }

    public function setHora_inicio($hora_inicio)
    {
        $this->hora_inicio = $hora_inicio;
        return $this;
    }

    public function getHora_fin()
    {
        return $this->hora_fin;
    }

    public function setHora_fin($hora_fin)
    {
        $this->hora_fin = $hora_fin;
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

    public function getCod_motivo()
    {
        return $this->cod_motivo;
    }

    public function setCod_motivo($cod_motivo)
    {
        $this->cod_motivo = $cod_motivo;
        return $this;
    }
}