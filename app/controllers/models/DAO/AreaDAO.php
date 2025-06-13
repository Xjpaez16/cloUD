<?php
class AreaDAO {
    private $conn;

    public function __construct() {
        require_once(__DIR__ . '../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    //Traer todas las áreas
    public function Todas_Areas() {
        try {
            $sql = "SELECT * FROM area";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $areas = [];
            while ($row = $result->fetch_assoc()) {
                $areas[] = new AreaDTO($row['codigo'], $row['nombre_area']);
            }
            return $areas;
        } catch (Exception $e) {
            error_log('Error en AreaDAO: ' . $e->getMessage());
            return [];
        }
    }
}
?>