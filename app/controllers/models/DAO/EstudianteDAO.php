<?php
require_once(__DIR__ . '/../DTO/EstudianteDTO.php');

class EstudianteDAO {
    private $conn;

    public function __construct($db) {
        require_once(__DIR__ . '/../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    // Crear estudiante
    public function create(EstudianteDTO $estudiante) {
        try {
            $sql = "INSERT INTO estudiante (codigo, nombre, correo, contraseña, respuesta_preg, cod_carrera, cod_estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                'ssssiii',
                $estudiante->getCodigo(),
                $estudiante->getNombre(),
                $estudiante->getCorreo(),
                $estudiante->getContrasena(),
                $estudiante->getRespuesta_preg(),
                $estudiante->getCod_carrera(),
                $estudiante->getCod_estado()
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
            error_log('Error en getByCodigo EstudianteDAO: ' . $e->getMessage());
            return null;
        }
    }

    // Obtener todos los estudiantes
    public function todos() {
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
            $stmt->bind_param(
                'ssssiii',
                $estudiante->getNombre(),
                $estudiante->getCorreo(),
                $estudiante->getContrasena(),
                $estudiante->getRespuesta_preg(),
                $estudiante->getCod_carrera(),
                $estudiante->getCod_estado(),
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
}
?>