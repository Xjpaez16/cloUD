<?php

class DiaDTO
{
    private $id;
    private $dia;

    public function __construct($id, $dia)
    {
        $this->id = $id;
        $this->dia = $dia;
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

    public function getDia()
    {
        return $this->dia;
    }

    public function setDia($dia)
    {
        $this->dia = $dia;
        return $this;
    }
}