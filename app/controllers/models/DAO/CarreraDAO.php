<?php

require_once(__DIR__ . '/../DTO/CarreraDTO.php');
class CarreraDAO
{
    private $conn;

    public function __construct()
    {
        require_once(__DIR__ . '/../../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    public function listcarrers()
    {
        try {
            $sql = "SELECT * FROM carrera";
            $result = $this->conn->query($sql);
            $carreras = [];

            while ($row = $result->fetch_assoc()) {
                $dto = new CarreraDTO();
                $dto->setCodigo($row['codigo']);
                $dto->setNom_carrera($row['nombre_carrera']);
                $carreras[] = $dto;
            }

            return $carreras;
        } catch (Exception $e) {
            error_log('Error en listar carreras: ' . $e->getMessage());
            return [];
        }
    }

    public function crearCarrera($codigo, $nombre) {
        $nombreLimpio = $this->limpiarEspacios($nombre);
        $nombreComparar = strtolower($nombreLimpio);

        $stmt = $this->conn->prepare("SELECT * FROM carrera WHERE codigo = ? OR TRIM(LOWER(nombre_carrera)) = ?");
        $stmt->bind_param("is", $codigo, $nombreComparar);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) return false;

        $stmt = $this->conn->prepare("INSERT INTO carrera (codigo, nombre_carrera) VALUES (?, ?)");
        $stmt->bind_param("is", $codigo, $nombreLimpio); // Aquí sí se guarda como lo ingresó el usuario (con mayúsculas o tildes)
        return $stmt->execute();
    }

    public function actualizarCarrera($codigo_actual, $codigo, $nombre) {
        $nombreLimpio = $this->limpiarEspacios($nombre);
        $nombreComparar = strtolower($nombreLimpio);

        $stmt = $this->conn->prepare("SELECT * FROM carrera WHERE (codigo = ? OR TRIM(LOWER(nombre_carrera)) = ?) AND codigo != ?");
        $stmt->bind_param("isi", $codigo, $nombreComparar, $codigo_actual);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) return false;

        $stmt = $this->conn->prepare("UPDATE carrera SET codigo = ?, nombre_carrera = ? WHERE codigo = ?");
        $stmt->bind_param("isi", $codigo, $nombreLimpio, $codigo_actual);
        return $stmt->execute();
    }

    private function limpiarEspacios($texto) {
        return preg_replace('/\s+/', ' ', trim($texto));
    }

}
