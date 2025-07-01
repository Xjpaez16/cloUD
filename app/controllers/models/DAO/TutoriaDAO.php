<?php
require_once(__DIR__ . '/../DTO/TutoriaDTO.php');
class TutoriaDAO {
    private $conn;
    
    public function __construct() {
        require_once(__DIR__ . '/../../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }
    
    /**
     * Crea una nueva tutoría en la base de datos
     * @param TutoriaDTO $tutoria
     * @return bool True si se creó correctamente, false en caso contrario
     */
    public function crearTutoria(TutoriaDTO $tutoria) {
        $this->conn->begin_transaction();
        
        try {
            $stmt = $this->conn->prepare("INSERT INTO agendar
            (cod_estudiante, cod_tutor, fecha, hora_inicio, hora_final, cod_estado)
            VALUES (?, ?, ?, ?, ?, ?)");
            
            $stmt->bind_param(
                "iisssi",
                $tutoria->getCod_estudiante(),
                $tutoria->getCod_tutor(),
                $tutoria->getFecha(),
                $tutoria->getHora_inicio(),
                $tutoria->getHora_fin(),
                $tutoria->getCod_estado()
                );
            
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
            
            $idTutoria = $this->conn->insert_id;
            $this->conn->commit();
            
            return $idTutoria;
            
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Error en crearTutoria: " . $e->getMessage());
            return false;
        }
    }
    
   
    
    /**
     * Obtiene una tutoría por su ID
     * @param int $idTutoria
     * @return TutoriaDTO|null El objeto TutoriaDTO o null si no se encuentra
     */
    public function obtenerTutoriaPorId($idTutoria) {
        $stmt = $this->conn->prepare("SELECT * FROM agendar WHERE id = ?");
        $stmt->bind_param("i", $idTutoria);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return new TutoriaDTO(
                $row['cod_estudiante'],
                $row['cod_tutor'],
                $row['id'],
                $row['fecha'],
                $row['hora_inicio'],
                $row['hora_final'],
                $row['cod_estado'],
                $row['cod_motivo']
                );
        }
        return null;
    }
    
    /**
     * Verifica la disponibilidad de un tutor en una fecha y hora específica
     * @param int $codTutor
     * @param string $fecha
     * @param string $horaInicio
     * @param string $horaFin
     * @return bool True si está disponible, false si no
     */
    public function verificarDisponibilidadTutor($codTutor, $fecha, $horaInicio, $horaFin) {
        // Verificar que no haya tutorías existentes en ese horario
        $stmt = $this->conn->prepare("
        SELECT 1 FROM agendar
        WHERE cod_tutor = ?
        AND fecha = ?
        AND (
            (hora_inicio < ? AND hora_final > ?) OR
            (hora_inicio BETWEEN ? AND ?) OR
            (hora_final BETWEEN ? AND ?) OR
            (? BETWEEN hora_inicio AND hora_final) OR
            (? BETWEEN hora_inicio AND hora_final)
        )");
        
        $stmt->bind_param("isssssssss",
            $codTutor, $fecha,
            $horaFin, $horaInicio, // Primer caso
            $horaInicio, $horaFin, // Segundo caso
            $horaInicio, $horaFin, // Tercer caso
            $horaInicio, $horaFin); // Cuarto y quinto caso
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return false; // Ya existe una tutoría en ese horario
            }
            
            // Verificar disponibilidad en la tabla disponibilidad
            $stmt = $this->conn->prepare("
        SELECT 1 FROM disponibilidad
        WHERE cod_tutor = ?
        AND fecha = ?
        AND hora_i <= ?
        AND hora_fn >= ?
        AND cod_estado = 4"); 
            
            $stmt->bind_param("isss", $codTutor, $fecha, $horaInicio, $horaFin);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->num_rows > 0;
    }
    
    /**
     * Cancela una tutoría cambiando su estado
     * @param int $idTutoria
     * @param int $nuevoEstado
     * @return bool True si se actualizó correctamente
     */
    public function cancelarTutoria($idTutoria, $nuevoEstado) {
        $stmt = $this->conn->prepare("UPDATE agendar SET cod_estado = ? WHERE id = ?");
        $stmt->bind_param("ii", $nuevoEstado, $idTutoria);
        return $stmt->execute();
    }
    
    private function actualizarDisponibilidad($codTutor, $fecha, $horaInicio, $horaFin) {
        // 1. Verificar si existe disponibilidad exacta
        $stmt = $this->conn->prepare("
            UPDATE disponibilidad
            SET cod_estado = 2
            WHERE cod_tutor = ?
            AND fecha = ?
            AND hora_i = ?
            AND hora_fn = ?
            AND cod_estado = 4");
        
        $stmt->bind_param("isss", $codTutor, $fecha, $horaInicio, $horaFin);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            return true;
        }
        
        // 2. Si no existe exactamente, buscar bloques que contengan este horario
        $stmt = $this->conn->prepare("
            SELECT id, hora_i, hora_fn
            FROM disponibilidad
            WHERE cod_tutor = ?
            AND fecha = ?
            AND hora_i <= ?
            AND hora_fn >= ?
            AND cod_estado = 1");
        
        $stmt->bind_param("isss", $codTutor, $fecha, $horaInicio, $horaFin);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $horaI = $row['hora_i'];
            $horaF = $row['hora_fn'];
            
            // Caso 1: El horario está al inicio del bloque
            if ($horaI == $horaInicio) {
                $this->conn->query("
                    INSERT INTO disponibilidad
                    (cod_tutor, fecha, hora_i, hora_fn, cod_estado)
                    VALUES ($codTutor, '$fecha', '$horaFin', '$horaF', 1)");
                
                $this->conn->query("
                    UPDATE disponibilidad
                    SET hora_fn = '$horaFin', cod_estado = 2
                    WHERE id = {$row['id']}");
                continue;
            }
            
            // Caso 2: El horario está al final del bloque
            if ($horaF == $horaFin) {
                $this->conn->query("
                    INSERT INTO disponibilidad
                    (cod_tutor, fecha, hora_i, hora_fn, cod_estado)
                    VALUES ($codTutor, '$fecha', '$horaI', '$horaInicio', 1)");
                
                $this->conn->query("
                    UPDATE disponibilidad
                    SET hora_i = '$horaInicio', cod_estado = 2
                    WHERE id = {$row['id']}");
                continue;
            }
            
            // Caso 3: El horario está en medio del bloque
            $this->conn->query("
                INSERT INTO disponibilidad
                (cod_tutor, fecha, hora_i, hora_fn, cod_estado)
                VALUES ($codTutor, '$fecha', '$horaI', '$horaInicio', 1)");
            
            $this->conn->query("
                INSERT INTO disponibilidad
                (cod_tutor, fecha, hora_i, hora_fn, cod_estado)
                VALUES ($codTutor, '$fecha', '$horaFin', '$horaF', 1)");
            
            $this->conn->query("
                UPDATE disponibilidad
                SET hora_i = '$horaInicio', hora_fn = '$horaFin', cod_estado = 2
                WHERE id = {$row['id']}");
        }
        
        return true;
    }
    
    public function aprobarTutoria($idTutoria) {
        $stmt = $this->conn->prepare("
        UPDATE agendar
        SET cod_estado = 5
        WHERE id = ?
    ");
        $stmt->bind_param("i", $idTutoria);
        return $stmt->execute();
    }
    
    public function rechazarTutoria($idTutoria, $codMotivo) {
        $stmt = $this->conn->prepare("
        UPDATE agendar
        SET cod_estado = 6,
            cod_motivo = ?
        WHERE id = ?
    ");
        $stmt->bind_param("ii", $codMotivo, $idTutoria);
        return $stmt->execute();
    }
    
    public function obtenerSolicitudesPendientes($codTutor) {
        $stmt = $this->conn->prepare("
        SELECT a.*,
               e.nombre as nombre_estudiante,
               e.correo as correo_estudiante
        FROM agendar a
        JOIN estudiante e ON a.cod_estudiante = e.codigo
        WHERE a.cod_tutor = ? AND a.cod_estado = 4
        ORDER BY a.fecha, a.hora_inicio
    ");
        $stmt->bind_param("i", $codTutor);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function actualizarEstado($idTutoria, $estado) {
        $stmt = $this->conn->prepare("UPDATE agendar SET cod_estado = ? WHERE id = ?");
        $stmt->bind_param("ii", $estado, $idTutoria);
        return $stmt->execute();
    }
    
    public function actualizarEstadoYMotivo($idTutoria, $estado, $motivo) {
        $stmt = $this->conn->prepare("UPDATE agendar SET cod_estado = ?, cod_motivo = ? WHERE id = ?");
        $stmt->bind_param("iii", $estado, $motivo, $idTutoria);
        return $stmt->execute();
    }
}
?>