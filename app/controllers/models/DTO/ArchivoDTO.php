<?php

class ArchivoDTO
{
    private $id;
    private $nombre;
    private $ruta;
    private $tamano;
    private $cod_profesor;
    private $cod_area;
    private $cod_estudiante;
    private $cod_estado;
    private $id_tipo;
    private $id_materia;
    private $cod_tutor;

    public function __construct()
    {
    }

    public function getCod_Tutor()
    {
        return $this->cod_tutor;
    }

    public function setCod_Tutor($cod_tutor)
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getRuta()
    {
        return $this->ruta;
    }

    public function setRuta($ruta)
    {
        $this->ruta = $ruta;
        return $this;
    }

    public function getTamano()
    {
        return $this->tamano;
    }

    public function setTamano($tamano)
    {
        $this->tamano = $tamano;
        return $this;
    }

    public function getCod_profesor()
    {
        return $this->cod_profesor;
    }

    public function setCod_profesor($cod_profesor)
    {
        $this->cod_profesor = $cod_profesor;
        return $this;
    }

    public function getCod_area()
    {
        return $this->cod_area;
    }

    public function setCod_area($cod_area)
    {
        $this->cod_area = $cod_area;
        return $this;
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

    public function getCod_estado()
    {
        return $this->cod_estado;
    }

    public function setCod_estado($cod_estado)
    {
        $this->cod_estado = $cod_estado;
        return $this;
    }

    public function getId_tipo()
    {
        return $this->id_tipo;
    }

    public function setId_tipo($id_tipo)
    {
        $this->id_tipo = $id_tipo;
        return $this;
    }

    public function getId_materia()
    {
        return $this->id_materia;
    }

    public function setId_materia($id_materia)
    {
        $this->id_materia = $id_materia;
        return $this;
    }
}