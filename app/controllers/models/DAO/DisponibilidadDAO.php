<?php
require_once(__DIR__ . '/../DTO/HorarioDTO.php');
require_once(__DIR__ . '/../DTO/DiaDTO.php');

class DisponibilidadDAO {
    private $conn;
    
    public function __construct() {
        require_once(__DIR__ . '/../../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }
    
    public function getDisponibilidadByTutor($cod_tutor) {
        try {
            $sql = "SELECT d.*, e.tipo_estado FROM disponibilidad d
                    JOIN estado e ON d.cod_estado = e.codigo
                    WHERE d.cod_tutor = ?";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('i', $cod_tutor);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $disponibilidades = [];
            while ($row = $result->fetch_assoc()) {
                $disponibilidades[] = [
                    'hora_i' => $row['hora_i'],
                    'hora_fn' => $row['hora_fn'],
                    'estado' => $row['tipo_estado']
                ];
            }
            return $disponibilidades;
        } catch (Exception $e) {
            error_log('Error en getDisponibilidadByTutor DisponibilidadDAO: ' . $e->getMessage());
            return [];
        }
    }
    
    public function create($cod_tutor, $hora_i, $hora_fn, $id_horario, $cod_estado) {
        try {
            $sql = "INSERT INTO disponibilidad (cod_tutor, hora_i, hora_fn, id_horario, cod_estado)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('issii', $cod_tutor, $hora_i, $hora_fn, $id_horario, $cod_estado);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error en create DisponibilidadDAO: ' . $e->getMessage());
            return false;
        }
    }
    
    public function getByTutor($cod_tutor) {
        try {
            $sql = "SELECT d.*, e.tipo_estado, dia.dia as nombre_dia
                FROM disponibilidad d
                JOIN estado e ON d.cod_estado = e.codigo
                JOIN horario h ON d.id_horario = h.id
                JOIN dia ON h.id_dia = dia.id
                WHERE d.cod_tutor = ?
                ORDER BY h.id_dia, d.hora_i";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('i', $cod_tutor);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $disponibilidades = [];
            while ($row = $result->fetch_assoc()) {
                $disponibilidades[] = [
                    'hora_i' => $row['hora_i'],
                    'hora_fn' => $row['hora_fn'],
                    'estado' => $row['tipo_estado'],
                    'dia' => $row['nombre_dia'] 
                ];
            }
            return $disponibilidades;
        } catch (Exception $e) {
            error_log('Error en getByTutor DisponibilidadDAO: ' . $e->getMessage());
            return [];
        }
    }
    public function getAvailableTutors() {
        try {
            $sql = "SELECT
            t.codigo AS code,
            t.nombre AS name,
            GROUP_CONCAT(DISTINCT a.nombre_area SEPARATOR ', ') AS subjects,
            dia.dia AS day_name,
            h.id_dia AS day_id,
            TIME_FORMAT(h.hora_inicio, '%h:%i %p') AS start_time,
            TIME_FORMAT(h.hora_fin, '%h:%i %p') AS end_time,
            t.calificacion_general AS rating
        FROM tutor t
        JOIN disponibilidad d ON t.codigo = d.cod_tutor
        JOIN estado e1 ON t.cod_estado = e1.codigo
        JOIN estado e2 ON d.cod_estado = e2.codigo
        JOIN horario h ON d.id_horario = h.id
        JOIN dia ON h.id_dia = dia.id
        LEFT JOIN area_tutor at ON t.codigo = at.cod_tutor
        LEFT JOIN area a ON at.cod_area = a.codigo
        WHERE t.cod_estado = 2  -- Tutor Verificado
          AND d.cod_estado = 7  -- Disponibilidad Activa
        GROUP BY t.codigo, t.nombre, dia.dia, h.id_dia, h.hora_inicio, h.hora_fin, t.calificacion_general
        ORDER BY h.id_dia, h.hora_inicio";
            
            error_log("Consulta de tutores disponibles ejecutada");
            
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                error_log("Error en preparación: " . $this->conn->error);
                return [];
            }
            
            if (!$stmt->execute()) {
                error_log("Error en ejecución: " . $stmt->error);
                return [];
            }
            
            $result = $stmt->get_result();
            $tutors = $result->fetch_all(MYSQLI_ASSOC);
            
            error_log("Tutores encontrados: " . count($tutors));
            return $tutors;
            
        } catch (Exception $e) {
            error_log('Error en getAvailableTutors: ' . $e->getMessage());
            return [];
        }
    }
    
    
    
    
    public function checkAvailability($tutorCode, $date, $startTime, $endTime) {
        try {
            $sql = "SELECT 1 FROM disponibilidad d
                JOIN estado e ON d.cod_estado = e.codigo
                JOIN horario h ON d.id_horario = h.id
                WHERE d.cod_tutor = ?
                AND h.fecha = ?
                AND d.hora_i = ?
                AND d.hora_fn = ?
                AND e.codigo = 7
                LIMIT 1";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('isss', $tutorCode, $date, $startTime, $endTime);
            $stmt->execute();
            return $stmt->get_result()->num_rows > 0;
            
        } catch (Exception $e) {
            error_log('Error checking availability: ' . $e->getMessage());
            return false;
        }
    }
}
?>