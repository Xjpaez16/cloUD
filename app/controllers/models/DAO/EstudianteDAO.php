<?php
require_once(__DIR__ . '/../DTO/EstudianteDTO.php');
require_once(__DIR__ . '/EstadoDAO.php');

class EstudianteDAO {
    private $conn;

    public function __construct() {
        require_once(__DIR__ . '/../../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    // Crear estudiante
    public function create(EstudianteDTO $estudiante) {
        try {
            $sql = "INSERT INTO estudiante (codigo, nombre, correo, contrasena, respuesta_preg, cod_carrera, cod_estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $codigo = $estudiante->getCodigo();
            $nombre = $estudiante->getNombre();
            $correo = $estudiante->getCorreo();
            $contrasena = $estudiante->getContrasena();
            $respuesta_preg = $estudiante->getRespuesta_preg();
            $cod_carrera = $estudiante->getCod_carrera();
            $cod_estado = $estudiante->getCod_estado();
            $stmt->bind_param(
                'issssiii',
                $codigo,
                $nombre,
                $correo,
                $contrasena,
                $respuesta_preg,
                $cod_carrera,
                $cod_estado,
            );
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error en crear EstudianteDAO: ' . $e->getMessage());
            return false;
        }
    }

    // Obtener estudiante por código
    public function getid($codigo) {
        try {
            $sql = "SELECT * FROM estudiante WHERE codigo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('i', $codigo);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return new EstudianteDTO(
                    $row['codigo'],
                    $row['nombre'],
                    $row['correo'],
                    $row['contrasena'],
                    $row['respuesta_preg'],
                    $row['cod_carrera'],
                    $row['cod_estado'],
                );
            }
            return null;
        } catch (Exception $e) {
            error_log('Error en getid EstudianteDAO: ' . $e->getMessage());
            return null;
        }
    }

    // Obtener todos los estudiantes
    public function getAll() {
        try {
            $sql = "SELECT * FROM estudiante";
            $result = $this->conn->query($sql);
            $estudiantes = [];
            while ($row = $result->fetch_assoc()) {
                $estudiantes[] = new EstudianteDTO(
                    $row['codigo'],
                    $row['nombre'],
                    $row['correo'],
                    $row['contrasena'],
                    $row['respuesta_preg'],
                    $row['cod_carrera'],
                    $row['cod_estado'],
                );
            }
            return $estudiantes;
        } catch (Exception $e) {
            error_log('Error en getAll EstudianteDAO: ' . $e->getMessage());
            return [];
        }
    }

    // Actualizar estudiante
    public function update($codigo_actual, EstudianteDTO $estudiante) {
        try {
            $sql = "UPDATE estudiante SET codigo = ?, nombre = ?, correo = ?, contrasena = ?, respuesta_preg = ?, cod_carrera = ?, cod_estado = ? WHERE codigo = ?";
            $stmt = $this->conn->prepare($sql);
            $codigo = $estudiante->getCodigo();
            $nombre = $estudiante->getNombre();
            $correo = $estudiante->getCorreo();
            $contrasena = $estudiante->getContrasena();
            $respuesta_preg = $estudiante->getRespuesta_preg();
            $cod_carrera = $estudiante->getCod_carrera();
            $cod_estado = $estudiante->getCod_estado();
            $stmt->bind_param(
                'issssiii',
                $codigo,
                $nombre,
                $correo,
                $contrasena,
                $respuesta_preg,
                $cod_carrera,
                $cod_estado,
                $codigo_actual
            );
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error en update EstudianteDAO: ' . $e->getMessage());
            return false;
        }
    }
   
    // Soft delete estudiante (cambiar estado)
    public function softDelete($codigo, $nuevoEstado) {
        try {
            $sql = "UPDATE estudiante SET cod_estado = ? WHERE codigo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ii', $nuevoEstado, $codigo);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error en softDelete EstudianteDAO: ' . $e->getMessage());
            return false;
        }
    }
    //Verificar si el estudiante está activo donde el estado es 2
    public function verificarEstado($email) {
    try {
        $sql = "SELECT cod_estado FROM estudiante e 
                JOIN estado es ON e.cod_estado = es.codigo
                WHERE e.correo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $email); 
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            
            return $row['cod_estado'] == 2;
        }
        return false; // Si no encuentra el usuario, retorna false
    } catch (Exception $email) {
        error_log('Error en verificarEstado EstudianteDAO: ' . $email->getMessage(). $email->getLine());
        return false;
    }
}
    // Validar login de estudiante
    public function validarLogin($correo) {
        try {
            $sql = "SELECT * FROM estudiante WHERE correo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('s', $correo);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return new EstudianteDTO(
                    $row['codigo'],
                    $row['nombre'],
                    $row['correo'],
                    $row['contrasena'],
                    $row['respuesta_preg'],
                    $row['cod_carrera'],
                    $row['cod_estado']
                );
            }
            return null;
        } catch (Exception $e) {
            error_log('Error en validar el Login EstudianteDAO: ' . $e->getMessage());
            return null;
        }
    }

    //comprobar correo
    public function comprobarCorreo($correo) {
        try {
            $sql = "SELECT * FROM estudiante WHERE correo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('s', $correo);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->num_rows > 0; // Retorna true si existe, false si no
        } catch (Exception $e) {
            error_log('Error en comprobar correo EstudianteDAO: ' . $e->getMessage());
            return false;
        }
    }

    //comprobar rta_seguridad
    public function comprobarRtaSeguridad($correo, $respuesta_preg) {
        try {
            $sql = "SELECT * FROM estudiante WHERE correo = ? AND respuesta_preg = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ss', $correo, $respuesta_preg);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->num_rows > 0; 
        } catch (Exception $e) {
            error_log('Error en comprobar rta_seguridad EstudianteDAO: ' . $e->getMessage());
            return false;
        }
    }
    //cambiar contraseña
    public function cambiarContrasena($correo, $nuevaContrasena) {
        try {
            $sql = "UPDATE estudiante SET contrasena = ? WHERE correo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ss', $nuevaContrasena, $correo);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error en cambiar contraseña EstudianteDAO: ' . $e->getMessage());
            return false;
        }
    }
    
    public function getStudentProfileById($codigo) {
        try {
            $sql = "SELECT
                    e.codigo,
                    e.nombre,
                    e.correo,
                    e.cod_carrera,
                    c.nombre_carrera,
                    e.cod_estado,
                    es.tipo_estado
                FROM estudiante e
                JOIN carrera c ON e.cod_carrera = c.codigo
                JOIN estado es ON e.cod_estado = es.codigo
                WHERE e.codigo = ?";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $codigo);
            $stmt->execute();
            
            $result = $stmt->get_result();
            return $result->fetch_assoc(); // Retorna array asociativo con los datos
            
        } catch (Exception $e) {
            error_log("Error al obtener perfil del estudiante: " . $e->getMessage());
            return null;
        }
    }
    
    // Métodos para activar/desactivar
public function desactivarEstudiante($codigo) {
    $stmt = $this->conn->prepare("UPDATE estudiante SET cod_estado = 3 WHERE codigo = ?");
    $stmt->bind_param("i", $codigo);
    return $stmt->execute();
}

public function activarEstudiante($codigo) {
    $stmt = $this->conn->prepare("UPDATE estudiante SET cod_estado = 2 WHERE codigo = ?");
    $stmt->bind_param("i", $codigo);
    return $stmt->execute();
}
}
?>