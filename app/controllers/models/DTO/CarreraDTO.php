<?php

class CarreraDTO
{
    private $codigo;
    private $nom_carrera;

    public function __construct($codigo = null, $nom_carrera = null)
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
