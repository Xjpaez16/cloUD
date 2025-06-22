<?php

class MateriaDTO
{
    private $id;
    private $nom_materia;

    public function __construct($id = null, $nom_materia = null)
    {
        $this->id = $id;
        $this->nom_materia = $nom_materia;
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

    public function getNom_materia()
    {
        return $this->nom_materia;
    }

    public function setNom_materia($nom_materia)
    {
        $this->nom_materia = $nom_materia;
        return $this;
    }
}