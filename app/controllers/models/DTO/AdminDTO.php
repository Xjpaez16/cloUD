<?php
require_once('UsuarioDTO.php');
class AdminDTO extends UsuarioDTO
{

    public function __construct($codigo = null, $nombre = null, $correo = null, $contrasena = null, $respuesta_preg = null)
    {
        parent::__construct($codigo, $nombre, $correo, $contrasena, $respuesta_preg);
    }

}
?>