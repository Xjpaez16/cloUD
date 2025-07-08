<?php
require_once __DIR__ . '/../DTO/Tipo_archivoDTO.php';

class Tipo_archivoDAO
{
    private $conn;

    public function __construct()
    {
        require_once(__DIR__ . '/../../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }
    
    // Listar todos los tipos
    public function obtenerTodos() {
        $tipos = [];
        $sql = "SELECT * FROM tipo_archivo";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $dto = new Tipo_archivoDTO();
            $dto->setId($row['id']);
            $dto->setTipo($row['nombre_tipo']);
            $tipos[] = $dto;
        }
        return $tipos;
    }

    // Crear nuevo tipo
    public function crear($codigo, $nombre) {
        $sql = "INSERT INTO tipo_archivo (id, nombre_tipo) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $codigo, $nombre);
        return $stmt->execute();
    }

    // Actualizar tipo
    public function actualizar($codigo_actual, $nuevo_codigo, $nuevo_nombre) {
        $sql = "UPDATE tipo_archivo SET id = ?, nombre_tipo = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isi", $nuevo_codigo, $nuevo_nombre, $codigo_actual);
        return $stmt->execute();
    }

    // Eliminar (lógico o físico)
    public function eliminar($codigo) {
        $sql = "DELETE FROM tipo_archivo WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $codigo);
        return $stmt->execute();
    }

    // Verifica si ya existe un tipo de archivo con ese código
    public function existeCodigo($codigo) {
        $sql = "SELECT 1 FROM tipo_archivo WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $codigo);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // Verifica si ya existe un tipo de archivo con ese nombre
    public function existeNombre($nombre) {
        $sql = "SELECT 1 FROM tipo_archivo WHERE nombre_tipo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function existeNombreEnOtro($nombre, $codigoActual) {
        $sql = "SELECT 1 FROM tipo_archivo WHERE nombre_tipo = ? AND id != ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $nombre, $codigoActual);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

}