<?php

class CarreraDTO
{
    public $codigo;
    public $nom_carrera;

    public function __construct($codigo, $nom_carrera)
    {
        $this->codigo = $codigo;
        $this->nom_carrera = $nom_carrera;
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

    public function getNom_carrera()
    {
        return $this->nom_carrera;
    }

    public function setNom_carrera($nom_carrera)
    {
        $this->nom_carrera = $nom_carrera;
        return $this;
    }
}