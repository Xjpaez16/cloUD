<?php
require_once(__DIR__ . '/../DTO/DiaDTO.php');

class DiaDAO {
    private $conn;
    
    public function __construct() {
        require_once(__DIR__ . '/../../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }
    
    public function getAll() {
        try {
            $sql = "SELECT * FROM dia";
            $result = $this->conn->query($sql);
            $dias = [];
            while ($row = $result->fetch_assoc()) {
                $dias[] = new DiaDTO($row['id'], $row['dia']);
            }
            return $dias;
        } catch (Exception $e) {
            error_log('Error en getAll DiaDAO: ' . $e->getMessage());
            return [];
        }
    }
    
    public function getById($id) {
        try {
            $sql = "SELECT * FROM dia WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return new DiaDTO($row['id'], $row['dia']);
            }
            return null;
        } catch (Exception $e) {
            error_log('Error en getById DiaDAO: ' . $e->getMessage());
            return null;
        }
    }
    public function getdaybyId($id_dia) {
        try {
            $sql = "SELECT * FROM dia WHERE id = ?";
            $stm = $this->conn->prepare($sql);
            $stm->bind_param("i", $id_dia);
            $stm->execute();
            $result = $stm->get_result();
            if ($row = $result->fetch_assoc()) {
                return new DiaDTO($row["id"], $row["dia"]);
            }
        }catch(Exception $e) {
        error_log("error al traer el dia". $e->getMessage());
        }
        
    }
}
?>