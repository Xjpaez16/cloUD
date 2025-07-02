<?php
require_once(__DIR__ . '/../DTO/HorarioDTO.php');

class HorarioDAO {
    private $conn;
    
    public function __construct() {
        require_once(__DIR__ . '/../../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }
    
    public function create(HorarioDTO $horario) {
        try {
            $sql = "INSERT INTO horario (id_dia, cod_tutor, hora_inicio, hora_fin) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $id_dia = $horario->getId_dia();
            $cod_tutor = $horario->getCod_tutor();
            $hora_inicio = $horario->getHora_inicio();
            $hora_fin = $horario->getHora_fin();
            
            $stmt->bind_param('iiss', $id_dia, $cod_tutor, $hora_inicio, $hora_fin);
            $stmt->execute();
            return $this->conn->insert_id;
        } catch (Exception $e) {
            error_log('Error en create HorarioDAO: ' . $e->getMessage());
            return false;
        }
    }
    
    public function getByTutor($cod_tutor) {
        try {
            $sql = "SELECT * FROM horario WHERE cod_tutor = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('i', $cod_tutor);
            $stmt->execute();
            $result = $stmt->get_result();
            $horarios = [];
            while ($row = $result->fetch_assoc()) {
                $horarios[] = new HorarioDTO(
                    $row['id'],
                    $row['id_dia'],
                    $row['cod_tutor'],
                    $row['hora_inicio'],
                    $row['hora_fin']
                    );
            }
            return $horarios;
        } catch (Exception $e) {
            error_log('Error en getByTutor HorarioDAO: ' . $e->getMessage());
            return [];
        }
    }
    public function getscheduleById($cod_tutor,$id_schedule) {
        try {
            $sql = "SELECT * FROM horario WHERE cod_tutor = ? AND id = ?";
            $stm = $this->conn->prepare($sql);
            $stm->bind_param("ii", $cod_tutor,$id_schedule);
            $stm->execute();
            $result = $stm->get_result();
            if ($row = $result->fetch_assoc()) {
                return new HorarioDTO(
                  $row["id"],
                  $row["id_dia"],
                  $row["cod_tutor"],
                  $row["hora_inicio"],
                  $row["hora_fin"],
                );
            }
            return null;
        }catch (Exception $e) {
            error_log("error al traer el horario: ". $e->getMessage());
        }
    }
}
?>