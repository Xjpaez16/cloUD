<?php
require_once(__DIR__ . '/../DTO/AdminDTO.php');

class AdminDAO {
    private $conn;
    
    public function __construct() {
        require_once(__DIR__ . '/../../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }
    
    public function obtenerAdminPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM administrador WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return new AdminDTO(
                $row['id'],
                $row['nombre'],
                $row['correo'],
                $row['clave'],
                $row['respuesta_preg']
                );
        }
        return null;
    }
    
    public function obtenerAdminPorCorreo($correo) {
        $stmt = $this->conn->prepare("SELECT * FROM administrador WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new AdminDTO(
                $row['id'],
                $row['nombre'],
                $row['correo'],
                $row['clave'],
                $row['respuesta_preg']
            );
        }
        return null;
    }

    public function obtenerTodos() {
        $result = $this->conn->query("SELECT * FROM administrador WHERE activo = 1");
        $admins = [];
        while ($row = $result->fetch_assoc()) {
            $admins[] = new AdminDTO(
                $row['id'],
                $row['nombre'],
                $row['correo'],
                $row['clave'],
                $row['respuesta_preg']
            );
        }
        return $admins;
    }

    public function crearAdmin($nombre, $correo, $clave, $respuesta_preg = '') {
        $stmt = $this->conn->prepare("INSERT INTO administrador (nombre, correo, clave, respuesta_preg, activo) VALUES (?, ?, ?, ?, 1)");
        $stmt->bind_param("ssss", $nombre, $correo, $clave, $respuesta_preg);
        return $stmt->execute();
    }

    public function actualizarAdmin($id, $nombre, $correo) {
        $stmt = $this->conn->prepare("UPDATE administrador SET nombre = ?, correo = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nombre, $correo, $id);
        return $stmt->execute();
    }

    public function desactivarAdmin($id) {
        $stmt = $this->conn->prepare("UPDATE administrador SET activo = 0 WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
