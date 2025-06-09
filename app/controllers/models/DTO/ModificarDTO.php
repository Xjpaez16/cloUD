<?php

class ModificarDTO
{
    private $cod_admin;
    private $cod_agendar;
    private $fecha;

    public function __construct($cod_admin, $cod_agendar, $fecha)
    {
        $this->cod_admin = $cod_admin;
        $this->cod_agendar = $cod_agendar;
        $this->fecha = $fecha;
    }

    public function getCod_admin()
    {
        return $this->cod_admin;
    }

    public function setCod_admin($cod_admin)
    {
        $this->cod_admin = $cod_admin;
        return $this;
    }

    public function getCod_agendar()
    {
        return $this->cod_agendar;
    }

    public function setCod_agendar($cod_agendar)
    {
        $this->cod_agendar = $cod_agendar;
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
}