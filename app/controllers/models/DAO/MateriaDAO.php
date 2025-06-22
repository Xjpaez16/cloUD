<?php
require_once(__DIR__ . '/../DTO/MateriaDTO.php');
class MateriaDAO
{

    private $conn;

    public function __construct()
    {
        require_once(__DIR__ . '/../../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    public function listmaterias()
    {
        try {
            $sql = "SELECT * FROM materia";
            $result = $this->conn->query($sql);
            $materias = [];
            while ($row = $result->fetch_assoc()) {
                $dto = new MateriaDTO();
                $dto->setId($row['id']);
                $dto->setNom_materia($row['nombre_materia']);
                $materias[] = $dto;
                error_log('Materias obtenidas: ' . $row['nombre_materia']);
            }
            return $materias;
        } catch (Exception $e) {
            error_log('Error en listar materias: ' . $e->getMessage());
            return [];
        }
    }
}
