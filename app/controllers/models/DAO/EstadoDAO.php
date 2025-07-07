<?php 
    class EstadoDAO {
        private $conn;

        // Constructor
        public function __construct() {
            require_once(__DIR__ . '/../../../../core/Conexion.php');
            $conexion = new Conexion();
            $this->conn = $conexion->getConexion();
        }

        // Obtener estado por ID
        public function getById($id) {
            try {
                $sql = "SELECT * FROM estado WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    return [
                        'id' => $row['id'],
                        'nombre' => $row['nombre']
                    ];
                }
                return null;
            } catch (Exception $e) {
                error_log('Error en getById EstadoDAO: ' . $e->getMessage());
                return null;
            }
        }
        // Obtener todos los estados
        public function getAll() {
            try {
                $sql = "SELECT * FROM estado";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $estados = [];
                while ($row = $result->fetch_assoc()) {
                    $estados[] = [
                        'codigo' => $row['codigo'],
                        'tipo_estado' => $row['tipo_estado']
                    ];
                }
                return $estados;
            } catch (Exception $e) {
                error_log('Error en getAll EstadoDAO: ' . $e->getMessage());
                return [];
            }
        }

        // Verificar duplicado por código o tipo_estado antes de insertar
        public function crearEstado($codigo, $tipo_estado) {
            $tipo_estado_normalizado = $this->normalizarTexto($tipo_estado);

            $stmt = $this->conn->prepare("SELECT * FROM estado");
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $nombre_bd_normalizado = $this->normalizarTexto($row['tipo_estado']);
                if ($nombre_bd_normalizado === $tipo_estado_normalizado || $row['codigo'] == $codigo) {
                    return false; // ya existe
                }
            }

            $stmt = $this->conn->prepare("INSERT INTO estado (codigo, tipo_estado) VALUES (?, ?)");
            $stmt->bind_param("is", $codigo, $tipo_estado);
            return $stmt->execute();
        }


        public function updateEstado($codigo_actual, $codigo, $tipo_estado) {
                    $tipo_estado_normalizado = $this->normalizarTexto($tipo_estado);

            $stmt = $this->conn->prepare("SELECT * FROM estado WHERE codigo != ?");
            $stmt->bind_param("i", $codigo_actual);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $nombre_bd_normalizado = $this->normalizarTexto($row['tipo_estado']);
                if ($nombre_bd_normalizado === $tipo_estado_normalizado || $row['codigo'] == $codigo) {
                    return false; // conflicto con otro estado
                }
            }

            $stmt = $this->conn->prepare("UPDATE estado SET codigo = ?, tipo_estado = ? WHERE codigo = ?");
            $stmt->bind_param("isi", $codigo, $tipo_estado, $codigo_actual);
            return $stmt->execute();
        }
        
        private function normalizarTexto($texto) {
            return strtolower(preg_replace('/\s+/', ' ', trim($texto)));
        }

    }
?>