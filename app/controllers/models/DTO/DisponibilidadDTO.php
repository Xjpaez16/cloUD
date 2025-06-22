<?php

class DisponibilidadDTO
{
    private $cod_tutor;
    private $hora_inicio;
    private $hora_fin;
    private $id_horario;
    private $cod_estado;

    public function __construct($cod_tutor, $hora_inicio, $hora_fin, $id_horario, $cod_estado)
    {
        $this->cod_tutor = $cod_tutor;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
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