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
            $sql = "INSERT INTO estudiante (codigo, nombre, correo, contraseña, respuesta_preg, cod_carrera, cod_estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $codigo = $estudiante->getCodigo();
            $nombre = $estudiante->getNombre();
            $correo = $estudiante->getCorreo();
            $contrasena = $estudiante->getContrasena();
            $respuesta_preg = $estudiante->getRespuesta_preg();
            $cod_carrera = $estudiante->getCod_carrera();
            $cod_estado = $estudiante->getCod_estado();
            $stmt->bind_param(
                'ssssiii',
                $codigo,
                $nombre,
                $correo,
                $contrasena,
                $respuesta_preg,
                $cod_carrera,
                $cod_estado
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
                    $row['contraseña'],
                    $row['respuesta_preg'],
                    $row['cod_carrera'],
                    $row['cod_estado']
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
                    $row['contraseña'],
                    $row['respuesta_preg'],
                    $row['cod_carrera'],
                    $row['cod_estado']
                );
            }
            return $estudiantes;
        } catch (Exception $e) {
            error_log('Error en getAll EstudianteDAO: ' . $e->getMessage());
            return [];
        }
    }

    // Actualizar estudiante
    public function update($codigo, EstudianteDTO $estudiante) {
        try {
            $sql = "UPDATE estudiante SET nombre = ?, correo = ?, contraseña = ?, respuesta_preg = ?, cod_carrera = ?, cod_estado = ? WHERE codigo = ?";
            $stmt = $this->conn->prepare($sql);
            $nombre = $estudiante->getNombre();
            $correo = $estudiante->getCorreo();
            $contrasena = $estudiante->getContrasena();
            $respuesta_preg = $estudiante->getRespuesta_preg();
            $cod_carrera = $estudiante->getCod_carrera();
            $cod_estado = $estudiante->getCod_estado();
            $stmt->bind_param(
                'ssssiii',
                $nombre,
                $correo,
                $contrasena,
                $respuesta_preg,
                $cod_carrera,
                $cod_estado,
                $codigo
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
    //Verificar si el estudiante está activo donde el estado es 1
    public function verificarEstado($email) {
        try {
            $sql = "SELECT cod_estado FROM estudiante e 
            JOIN estado es ON e.cod_estado = es.codigo
            WHERE  es.tipo_estado = 'Verificado' AND e.correo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc() ) {
                return $row['cod_estado'] == 1; //retorna true
            }
            
        } catch (Exception $email) {
            error_log('Error en verificarEstado EstudianteDAO: ' . $email->getMessage());
            return false;
        }
    }
    // Validar login de estudiante
    public function validarLogin($correo) {
        try {
            $sql = "SELECT * FROM estudiante WHERE correo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('s', $correo, );
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return new EstudianteDTO(
                    $row['codigo'],
                    $row['nombre'],
                    $row['correo'],
                    $row['contraseña'],
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
            $sql = "UPDATE estudiante SET contraseña = ? WHERE correo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ss', $nuevaContrasena, $correo);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error en cambiar contraseña EstudianteDAO: ' . $e->getMessage());
            return false;
        }
    }

   
}
?>