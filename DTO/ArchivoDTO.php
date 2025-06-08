<?php

class ArchivoDTO
{
    public $id;
    public $ruta;
    public $tamano;
    public $cod_profesor;
    public $cod_area;
    public $cod_estudiante;
    public $cod_estado;
    public $id_tipo;
    public $id_materia;

    public function __construct($id, $ruta, $tamano, $cod_profesor, $cod_area, $cod_estudiante, $cod_estado, $id_tipo, $id_materia)
    {
        $this->id = $id;
        $this->ruta = $ruta;
        $this->tamano = $tamano;
        $this->cod_profesor = $cod_profesor;
        $this->cod_area = $cod_area;
        $this->cod_estudiante = $cod_estudiante;
        $this->cod_estado = $cod_estado;
        $this->id_tipo = $id_tipo;
        $this->id_materia = $id_materia;
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