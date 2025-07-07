<?php
require_once(__DIR__ . '/../DTO/ProfesorDTO.php');
class ProfesorDAO
{

    private $conn;

    public function __construct()
    {
        require_once(__DIR__ . '/../../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }
    public function listteachers()
    {
        try {
            $sql = "SELECT * FROM profesor";
            $result = $this->conn->query($sql);
            $profesores = [];

            while ($row = $result->fetch_assoc()) {
                $dto = new ProfesorDTO();
                $dto->setCod($row['codigo']);
                $dto->setNom($row['nombre']);
                $profesores[] = $dto;
            }
            return $profesores;
        } catch (Exception $e) {
            echo "Error al traer los profesores: " . $e->getMessage();
            return [];
        }
    }

    public function crearProfesor($codigo, $nombre)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO profesor (codigo, nombre) VALUES (?, ?)");
            $stmt->bind_param("is", $codigo, $nombre);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Error al crear el profesor: " . $e->getMessage();
            return false;
        }
    }

    public function actualizarProfesor($codigo_actual, $nombre)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE profesor SET nombre = ? WHERE codigo = ?");
            $stmt->bind_param("ss", $nombre, $codigo_actual);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Error al actualizar el profesor: " . $e->getMessage();
            return false;
        }
    }

    public function crearRelacion($codigo, $materia, $area)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO area_profesor (cod_profesor, cod_materia, cod_area) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $codigo, $materia, $area);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Error al crear la relación: " . $e->getMessage();
            return false;
        }
    }
}