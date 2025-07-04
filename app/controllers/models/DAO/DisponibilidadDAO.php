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
                    'cod_tutor' => $row['cod_tutor'],
                    'hora_i' => $row['hora_i'],
                    'hora_fn' => $row['hora_fn'],
                    'id_horario' => $row['id_horario'],
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
    public function updatedispo($cod_tutor,$id_horario,$hora_i,$hora_fn){
        try{
            $sql = "UPDATE disponibilidad
            SET cod_estado = 8
            WHERE cod_tutor = ?
            AND id_horario = ?
            AND hora_i >= ?
            AND hora_fn <= ? ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('iiss', $cod_tutor,$id_horario,$hora_i,$hora_fn);
            $stmt->execute();
            
        }catch(Exception $e){
            error_log('Error en updatedispo DisponibilidadDAO' . $e->getMessage());
        }
    }
    
    /**
     * Elimina una disponibilidad específica
     */
    public function eliminarDisponibilidad($codTutor, $horaI, $horaFn, $idHorario) {
        try {
            $sql = "DELETE FROM disponibilidad
                WHERE cod_tutor = ? AND hora_i = ? AND hora_fn = ? AND id_horario = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("issi", $codTutor, $horaI, $horaFn, $idHorario);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en eliminarDisponibilidad: " . $e->getMessage());
            return false;
        }
    }
    
    
    /**
     * Obtiene una disponibilidad por ID
     */
    public function obtenerPorId($codTutor, $idHorario) {
        try {
            $sql = "SELECT d.cod_tutor, d.id_horario, h.id_dia, h.hora_inicio, h.hora_fin
                FROM disponibilidad d
                JOIN horario h ON d.id_horario = h.id
                WHERE d.cod_tutor = ? AND d.id_horario = ?";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $codTutor, $idHorario);
            $stmt->execute();
            
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return $row;
            } else {
                return false;
            }
        } catch(Exception $e) {
            error_log("Error en obtenerPorId: " . $e->getMessage());
            return false;
        }
    }
    
    
    
    
    
    
    /**
     * Actualiza una disponibilidad
     */
    public function actualizarDisponibilidad() {
        $this->verificarSesionTutor();
        
        $id_horario = $_POST['id_horario'] ?? null;
        $id_dia = $_POST['dia'] ?? null;
        $hora_inicio = $_POST['hora_inicio'] ?? null;
        $hora_fin = $_POST['hora_fin'] ?? null;
        $cod_tutor = $_POST['cod_tutor'] ?? null;
        
        if (!$id_horario || !$id_dia || !$hora_inicio || !$hora_fin || !$cod_tutor) {
            header("Location: " . BASE_URL . "index.php?url=RouteController/viewAvailability&error=1");
            exit();
        }
        
        // Validar que la hora final sea al menos 1 hora mayor
        if (!$this->validateTimeInterval($hora_inicio, $hora_fin)) {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/viewAvailability&error=4');
            exit;
        }
        
        // Actualizar horario
        $horarioDTO = new HorarioDTO($id_horario, $id_dia, $cod_tutor, $hora_inicio, $hora_fin);
        $resultado = $this->horarioDAO->update($horarioDTO);
        
        if (!$resultado) {
            header("Location: " . BASE_URL . "index.php?url=RouteController/viewAvailability&error=2");
            exit();
        }
        
        // Eliminar bloques de disponibilidad actuales
        $this->disponibilidadDAO->eliminarPorHorario($cod_tutor, $id_horario);
        
        // Insertar nuevos bloques de disponibilidad por cada hora
        $this->registerTimeSlots($cod_tutor, $hora_inicio, $hora_fin, $id_horario);
        
        header("Location: " . BASE_URL . "index.php?url=RouteController/viewAvailability&success=2");
        exit();
    }
    
    
    public function actualizarDisponibilidadPorID($idDisponibilidad, $idDia, $horaInicio, $horaFin, $codTutor) {
        $conn = $this->db->getConnection();
        
        $query = "UPDATE disponibilidad SET id_dia = ?, hora_inicio = ?, hora_fin = ?
              WHERE id_horario = ? AND cod_tutor = ?";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssii", $idDia, $horaInicio, $horaFin, $idDisponibilidad, $codTutor);
        
        return $stmt->execute();
    }
    
    public function eliminarPorHorario($codTutor, $idHorario) {
        try {
            $sql = "DELETE FROM disponibilidad WHERE cod_tutor = ? AND id_horario = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $codTutor, $idHorario);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error al eliminar disponibilidad: " . $e->getMessage());
            return false;
        }
    }
    
    
}
?>