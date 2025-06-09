<?php

class ProfesorDTO
{
    private $cod;
    private $nom;

    public function __construct($cod, $nom)
    {
        $this->cod = $cod;
        $this->nom = $nom;
    }

    public function getCod()
    {
        return $this->cod;
    }

    public function setCod($cod)
    {
        $this->cod = $cod;
        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }
}