<?php
require_once(__DIR__ . '/../DTO/AreaDTO.php');
class AreaDAO
{
    private $conn;

    public function __construct()
    {
        require_once(__DIR__ . '/../../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    //Traer todas las áreas
    public function listarea()
    {
        try {
            $sql = "SELECT * FROM area";
            $result = $this->conn->query($sql);
            $areas = [];

            while ($row = $result->fetch_assoc()) {
                $dto = new AreaDTO();
                $dto->setCodigo($row['codigo']);
                $dto->setNombre($row['nombre_area']);
                $areas[] = $dto;
                error_log('Área obtenida: ' . $row['nombre_area']);
            }

            return $areas;
        } catch (Exception $e) {
            error_log('Error en listar areas: ' . $e->getMessage());
            return [];
        }
    }

    public function getAreabyteacher($id_profesor)
    {
        try {
            $sql = "SELECT DISTINCT a.nombre_area, a.codigo 
                    FROM area a 
                    JOIN area_profesor pa 
                    ON a.codigo = pa.cod_area 
                    WHERE pa.cod_profesor = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id_profesor);
            $stmt->execute();
            $result = $stmt->get_result();
            $areas = [];

            while ($row = $result->fetch_assoc()) {
                $dto = new AreaDTO();
                $dto->setCodigo($row['codigo']);
                $dto->setNombre($row['nombre_area']);
                $areas[] = $dto;
            }

            return $areas;
        } catch (Exception $e) {
            error_log('Error al obtener áreas por profesor: ' . $e->getMessage());
            return [];
        }
    }
}
?>