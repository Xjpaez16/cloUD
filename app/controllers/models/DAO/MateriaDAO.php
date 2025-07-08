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

    public function crearMateria($id, $nombre_materia) {
        $nombreLimpio = $this->limpiarEspacios($nombre_materia);
        $nombreComparar = strtolower($nombreLimpio);

        $stmt = $this->conn->prepare("SELECT * FROM materia WHERE id = ? OR TRIM(LOWER(nombre_materia)) = ?");
        $stmt->bind_param("is", $id, $nombreComparar);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) {
            return false;
        }

        $stmt = $this->conn->prepare("INSERT INTO materia (id, nombre_materia) VALUES (?, ?)");
        $stmt->bind_param("is", $id, $nombreLimpio);
        return $stmt->execute();
    }

    public function actualizarMateria($id_actual, $id_nuevo, $nombre_materia) {
        $nombreLimpio = $this->limpiarEspacios($nombre_materia);
        $nombreComparar = strtolower($nombreLimpio);

        $stmt = $this->conn->prepare("SELECT * FROM materia WHERE (id = ? OR TRIM(LOWER(nombre_materia)) = ?) AND id != ?");
        $stmt->bind_param("isi", $id_nuevo, $nombreComparar, $id_actual);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) {
            return false;
        }

        $stmt = $this->conn->prepare("UPDATE materia SET id = ?, nombre_materia = ? WHERE id = ?");
        $stmt->bind_param("isi", $id_nuevo, $nombreLimpio, $id_actual);
        return $stmt->execute();
    }


    private function limpiarEspacios($texto) {
        return trim(preg_replace('/\s+/', ' ', $texto));
    }

}
