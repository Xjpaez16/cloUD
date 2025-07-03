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
    public function getAvailableTutorsWithAreas($filtros = [])
    {
        $sql = "SELECT
                t.codigo,
                t.nombre,
                t.correo,
                IFNULL(t.calificacion_general, 0) as calificacion_general,
                GROUP_CONCAT(DISTINCT a.nombre_area SEPARATOR ', ') as areas,
                dia.dia as nombre_dia,
                h.id_dia,
                h.id as id_horario,
                TIME_FORMAT(h.hora_inicio, '%h:%i %p') as hora_inicio,
                TIME_FORMAT(h.hora_fin, '%h:%i %p') as hora_fin
            FROM tutor t
            LEFT JOIN area_tutor at ON t.codigo = at.cod_tutor
            LEFT JOIN area a ON at.cod_area = a.codigo
            LEFT JOIN disponibilidad d ON t.codigo = d.cod_tutor
            LEFT JOIN horario h ON d.id_horario = h.id
            LEFT JOIN dia ON h.id_dia = dia.id
            WHERE t.cod_estado = 2"; // Solo tutores verificados
        
        $params = [];
        $types = '';
        
        // Filtro por área
        if (!empty($filtros['area'])) {
            $sql .= " AND a.codigo = ?";
            $params[] = $filtros['area'];
            $types .= 'i';
        }
        
        // Agregamos GROUP BY con todas las columnas no agregadas
        $sql .= " GROUP BY t.codigo, t.nombre, t.correo, t.calificacion_general,
              dia.dia, h.id_dia, h.id, h.hora_inicio, h.hora_fin";
        
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt === false) {
            error_log("Error en prepare: " . $this->conn->error);
            return [];
        }
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        if (!$stmt->execute()) {
            error_log("Error en execute: " . $stmt->error);
            return [];
        }
        
        $result = $stmt->get_result();
        
        $tutores = [];
        while ($row = $result->fetch_assoc()) {
            // Solo agregamos horarios válidos
            if (!empty($row['hora_inicio']) && !empty($row['hora_fin'])) {
                $tutores[] = $row;
            }
        }
        
        return $tutores;
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
    public function updatedispo($cod_tutor,$hora_i,$hora_fn){
        try{
            $sql = "UPDATE disponibilidad
            SET cod_estado = 8
            WHERE cod_tutor = ?
            AND id_horario = 2
            AND hora_i >= ?
            AND hora_fn <= ? ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('iss', $cod_tutor,$hora_i,$hora_fn);
            $stmt->execute();
            
        }catch(Exception $e){
            error_log('Error en updatedispo DisponibilidadDAO' . $e->getMessage());
        }
    }
}
?>