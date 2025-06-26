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
}
?>
