<?php
require_once('UsuarioDTO.php');

class AdministradorDTO extends UsuarioDTO
{
    private $id_admin;

    public function __construct($codigo = null, $nombre = null, $correo = null, $contrasena = null, $respuesta_preg = null, $id_admin = null)
    {
        parent::__construct($codigo, $nombre, $correo, $contrasena, $respuesta_preg);
        $this->id_admin = $id_admin;
    }

    public function getId_admin()
    {
        return $this->id_admin;
    }

    public function setId_admin($id_admin)
    {
        $this->id_admin = $id_admin;
        return $this;
    }
}

?>