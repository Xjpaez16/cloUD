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

    public function listar_Motivos() {
        $result = $this->conn->query("SELECT * FROM motivo");
        $motivos = [];
        while ($row = $result->fetch_assoc()) {
            $dto = new MotivoDTO();
            $dto->setCodigo($row['codigo']);
            $dto->setTipo_motivo($row['tipo_motivo']);
            $motivos[] = $dto;
        }
        return $motivos;
    }

    public function crearMotivo($codigo, $tipo) {
        $tipoLimpio = $this->normalizarTexto($tipo);
        $tipoComparar = strtolower($tipoLimpio);

        // Validación con consulta SQL para mejorar eficiencia
        $stmt = $this->conn->prepare("SELECT * FROM motivo WHERE codigo = ? OR TRIM(LOWER(tipo_motivo)) = ?");
        $stmt->bind_param("is", $codigo, $tipoComparar);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) return false;

        // Insertar nuevo motivo (se guarda como lo ingresó el usuario)
        $stmt = $this->conn->prepare("INSERT INTO motivo (codigo, tipo_motivo) VALUES (?, ?)");
        $stmt->bind_param("is", $codigo, $tipoLimpio);
        return $stmt->execute();
    }


    public function actualizarMotivo($codigo_actual, $codigo, $tipo) {
        $tipoLimpio = $this->normalizarTexto($tipo);
        $tipoComparar = strtolower($tipoLimpio);

        // Validación usando SQL eficiente
        $stmt = $this->conn->prepare("SELECT * FROM motivo WHERE (codigo = ? OR TRIM(LOWER(tipo_motivo)) = ?) AND codigo != ?");
        $stmt->bind_param("isi", $codigo, $tipoComparar, $codigo_actual);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) return false;

        // Actualizar motivo
        $stmt = $this->conn->prepare("UPDATE motivo SET codigo = ?, tipo_motivo = ? WHERE codigo = ?");
        $stmt->bind_param("isi", $codigo, $tipoLimpio, $codigo_actual);
        return $stmt->execute();
    }



    private function normalizarTexto($texto) {
        $texto = trim($texto);
        $texto = preg_replace('/\s+/', ' ', $texto);
        return $texto;
    }

}
?>