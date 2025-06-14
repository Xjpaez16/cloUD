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
}
