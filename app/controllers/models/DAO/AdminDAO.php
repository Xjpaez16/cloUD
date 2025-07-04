<?php
require_once(__DIR__ . '/../DTO/AdminDTO.php');
class AdminDAO {
    private $conn;
    public function __construct() {
        require_once(__DIR__ . '/../../../../core/Conexion.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    public function obtenerAdminPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM administrador WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new AdminDTO($row['id'], $row['nombre'], $row['correo'], $row['clave'], $row['respuesta_preg'], $row['activo']);
        }
        return null;
    }

    public function obtenerAdminPorCorreo($correo) {
        $stmt = $this->conn->prepare("SELECT * FROM administrador WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new AdminDTO($row['id'], $row['nombre'], $row['correo'], $row['clave'], $row['respuesta_preg'], $row['activo']);
        }
        return null;
    }

    public function obtenerTodos() {
        $result = $this->conn->query("SELECT * FROM administrador");
        $admins = [];
        while ($row = $result->fetch_assoc()) {
            $admins[] = new AdminDTO($row['id'], $row['nombre'], $row['correo'], $row['clave'], $row['respuesta_preg'], $row['activo']);
        }
        return $admins;
    }

    public function crearAdmin($id, $nombre, $correo, $clave, $respuesta_preg) {
        // Validar si ya existe ese ID
        $stmt = $this->conn->prepare("SELECT id FROM administrador WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return false; // Ya existe
        }

        // Insertar nuevo
        $stmt = $this->conn->prepare("INSERT INTO administrador (id, nombre, correo, clave, respuesta_preg, activo) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("issss", $id, $nombre, $correo, $clave, $respuesta_preg);
        return $stmt->execute();
    }



    public function actualizarAdmin($id, $nombre, $correo, $respuesta_preg) {
        $stmt = $this->conn->prepare("UPDATE administrador SET nombre = ?, correo = ?, respuesta_preg = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nombre, $correo, $respuesta_preg, $id);
        return $stmt->execute();
    }

    public function desactivarAdmin($id) {
        $stmt = $this->conn->prepare("UPDATE administrador SET activo = 0 WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function activarAdmin($id) {
        $stmt = $this->conn->prepare("UPDATE administrador SET activo = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function actualizarAdminConNuevoID($codigo_actual, $nuevo_id, $nombre, $correo, $respuesta_preg) {
        try {
            $stmt = $this->conn->prepare("UPDATE administrador SET id = ?, nombre = ?, correo = ?, respuesta_preg = ? WHERE id = ?");
            $stmt->bind_param("isssi", $nuevo_id, $nombre, $correo, $respuesta_preg, $codigo_actual);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                return false;
            }
            throw $e;
        }
    }


}
?>
