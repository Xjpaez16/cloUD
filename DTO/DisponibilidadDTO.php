<?php

class DisponibilidadDTO
{
    public $cod_tutor;
    public $hora_inicio;
    public $hora_fin;
    public $fecha;
    public $id_horario;
    public $cod_estado;

    public function __construct($cod_tutor, $hora_inicio, $hora_fin, $fecha, $id_horario, $cod_estado)
    {
        $this->cod_tutor = $cod_tutor;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
        $this->fecha = $fecha;
        $this->id_horario = $id_horario;
        $this->cod_estado = $cod_estado;
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

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    public function getId_horario()
    {
        return $this->id_horario;
    }

    public function setId_horario($id_horario)
    {
        $this->id_horario = $id_horario;
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