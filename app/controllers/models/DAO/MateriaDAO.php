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
            }
            return $materias;
        } catch (Exception $e) {
            error_log('Error en listar materias: ' . $e->getMessage());
            return [];
        }
    }

    public function getMateriasByArea($areacodigo, $profesorid)
    {
        try {
            $sql = "SELECT DISTINCT m.nombre_materia, m.id
                    FROM area a
                    JOIN area_profesor pa ON a.codigo = pa.cod_area 
                    JOIN materia as m ON m.id = pa.cod_materia 
                    WHERE pa.cod_area = ? AND pa.cod_profesor = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $areacodigo, $profesorid);
            $stmt->execute();
            $result = $stmt->get_result();
            $materias = [];

            while ($row = $result->fetch_assoc()) {
                $dto = new MateriaDTO();
                $dto->setId($row['id']);
                $dto->setNom_materia($row['nombre_materia']);
                $materias[] = $dto;
            }

            return $materias;
        } catch (Exception $e) {
            error_log('Error al obtener materias por área: ' . $e->getMessage());
            return [];
        }
    }
}
