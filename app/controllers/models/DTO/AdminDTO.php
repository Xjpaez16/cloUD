<?php
require_once('UsuarioDTO.php');
class AdminDTO extends UsuarioDTO {
    protected $activo;

    public function __construct($codigo = null, $nombre = null, $correo = null, $contrasena = null, $respuesta_preg = null, $activo = 1) {
        parent::__construct($codigo, $nombre, $correo, $contrasena, $respuesta_preg, $activo);
        $this->activo = $activo;
    }

    public function getActivo()
{
    return $this->activo;
}

}
?>