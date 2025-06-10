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
                        'id' => $row['id'],
                        'nombre' => $row['nombre']
                    ];
                }
                return $estados;
            } catch (Exception $e) {
                error_log('Error en getAll EstadoDAO: ' . $e->getMessage());
                return [];
            }
        }
    }
?>