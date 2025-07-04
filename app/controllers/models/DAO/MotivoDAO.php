<?php
require_once(__DIR__ . '/../DTO/MotivoDTO.php');

class MotivoDAO {
    private $conn;
    
    public function __construct() {
        require_once(__DIR__ . '/../../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }
    
    /**
     * Lista todos los motivos disponibles
     * @return array Array de objetos MotivoDTO
     */
    public function listarMotivos() {
        $stmt = $this->conn->query("SELECT * FROM motivo");
        $motivos = [];
        
        while ($row = $stmt->fetch_assoc()) {
            $motivos[] = new MotivoDTO(
                $row['codigo'],
                $row['tipo_motivo']
                );
        }
        
        return $motivos;
    }
    
    /**
     * Obtiene un motivo por su código
     * @param int $codigo
     * @return MotivoDTO|null
     */
    public function obtenerMotivoPorCodigo($codigo) {
        $stmt = $this->conn->prepare("SELECT * FROM motivo WHERE codigo = ?");
        $stmt->bind_param("i", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return new MotivoDTO(
                $row['codigo'],
                $row['tipo_motivo']
                );
        }
        
        return null;
    }
}
?>