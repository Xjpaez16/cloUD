<?php

class HorarioDTO
{
    private $id;
    private $id_dia;
    private $cod_tutor;
    private $hora_inicio;
    private $hora_fin;

    public function __construct($id, $id_dia, $cod_tutor, $hora_inicio, $hora_fin)
    {
        $this->id = $id;
        $this->id_dia = $id_dia;
        $this->cod_tutor = $cod_tutor;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
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

    public function getId_dia()
    {
        return $this->id_dia;
    }

    public function setId_dia($id_dia)
    {
        $this->id_dia = $id_dia;
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
}