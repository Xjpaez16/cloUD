<?php
require_once(__DIR__ . '/../../../../core/Conexion.php');
require_once(__DIR__ . '/../DTO/AdministradorDTO.php');
require_once(__DIR__ . '/../DTO/UsuarioDTO.php');

class AdministradorDAO
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }

    public function create(AdministradorDTO $administrador)
    {
        $conn = $this->conexion->getConexion();
        $query = "INSERT INTO administrador (id, correo, nombre, clave, respuesta_preg) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        $id = $administrador->getCodigo();
        $correo = $administrador->getCorreo();
        $nombre = $administrador->getNombre();
        $clave = $administrador->getContrasena();
        $respuesta_preg = $administrador->getRespuesta_preg();

        $stmt->bind_param("sssss", $id, $correo, $nombre, $clave, $respuesta_preg);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error al crear administrador: " . $stmt->error);
            return false;
        }
    }

    public function getAllAdministradores()
    {
        $conn = $this->conexion->getConexion();
        $query = "SELECT id, correo, nombre, clave, respuesta_preg FROM administrador";
        $result = $conn->query($query);

        $administradores = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $administrador = new AdministradorDTO(
                    $row['id'],
                    $row['nombre'],
                    $row['correo'],
                    $row['clave'],
                    $row['respuesta_preg'],
                    $row['id']
                );
                $administradores[] = $administrador;
            }
        }
        return $administradores;
    }

    public function getAdministradorById($id)
    {
        $conn = $this->conexion->getConexion();
        $query = "SELECT id, correo, nombre, clave, respuesta_preg FROM administrador WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $administrador = new AdministradorDTO(
                $row['id'],
                $row['nombre'],
                $row['correo'],
                $row['clave'],
                $row['respuesta_preg'],
                $row['id']
            );
            return $administrador;
        }
        return null;
    }

    public function update(AdministradorDTO $administrador)
    {
        $conn = $this->conexion->getConexion();
        $query = "UPDATE administrador SET correo = ?, nombre = ?, clave = ?, respuesta_preg = ? WHERE id = ?";
        $stmt = $conn->prepare($query);

        $correo = $administrador->getCorreo();
        $nombre = $administrador->getNombre();
        $clave = $administrador->getContrasena();
        $respuesta_preg = $administrador->getRespuesta_preg();
        $id = $administrador->getCodigo();

        $stmt->bind_param("sssss", $correo, $nombre, $clave, $respuesta_preg, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error al actualizar administrador: " . $stmt->error);
            return false;
        }
    }

    public function delete($id)
    {
        $conn = $this->conexion->getConexion();
        $query = "DELETE FROM administrador WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error al eliminar administrador: " . $stmt->error);
            return false;
        }
    }

    public function comprobarCorreo($correo)
    {
        $conn = $this->conexion->getConexion();
        $query = "SELECT COUNT(*) FROM administrador WHERE correo = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count > 0;
    }

    public function validarLogin($correo)
    {
        $conn = $this->conexion->getConexion();
        $query = "SELECT id, correo, nombre, clave, respuesta_preg FROM administrador WHERE correo = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $administrador = new AdministradorDTO(
                $row['id'],
                $row['nombre'],
                $row['correo'],
                $row['clave'],
                $row['respuesta_preg'],
                $row['id']
            );
            return $administrador;
        }
        return null;
    }

    public function cambiarContrasena($correo, $nuevaContrasenaHasheada)
    {
        $conn = $this->conexion->getConexion();
        $query = "UPDATE administrador SET clave = ? WHERE correo = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $nuevaContrasenaHasheada, $correo);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error al cambiar la contraseña del administrador: " . $stmt->error);
            return false;
        }
    }

    public function comprobarRtaSeguridad($correo, $respuestaSeguridadConcatenada)
    {
        $conn = $this->conexion->getConexion();
        $query = "SELECT COUNT(*) FROM administrador WHERE correo = ? AND respuesta_preg = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $correo, $respuestaSeguridadConcatenada);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count > 0;
    }
}

?>