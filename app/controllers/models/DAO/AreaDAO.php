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

    public function crearArea($codigo, $nombre) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO area (codigo, nombre_area) VALUES (?, ?)");
            $stmt->bind_param("is", $codigo, $nombre);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error creando área: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarArea($codigo_actual, $nuevo_codigo, $nombre) {
        try {
            $nombreLimpio = $this->limpiarEspacios($nombre);
            $nombreComparar = strtolower($nombreLimpio);

            // Verificar si ya existe un área con el mismo código o nombre (excepto la actual)
            $stmt = $this->conn->prepare("SELECT * FROM area WHERE (codigo = ? OR TRIM(LOWER(nombre_area)) = ?) AND codigo != ?");
            $stmt->bind_param("isi", $nuevo_codigo, $nombreComparar, $codigo_actual);
            $stmt->execute();

            if ($stmt->get_result()->num_rows > 0) {
                return false;
            }

            // Actualizar área
            $stmt = $this->conn->prepare("UPDATE area SET codigo = ?, nombre_area = ? WHERE codigo = ?");
            $stmt->bind_param("isi", $nuevo_codigo, $nombreLimpio, $codigo_actual);
            return $stmt->execute();

        } catch (Exception $e) {
            error_log("Error actualizando área: " . $e->getMessage());
            return false;
        }
    }


    // Verifica si ya existe un tipo de archivo con ese código
    public function existeCodigo($codigo) {
        $sql = "SELECT 1 FROM area WHERE codigo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $codigo);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // Verifica si ya existe un tipo de archivo con ese nombre
    public function existeNombre($nombre) {
        $sql = "SELECT 1 FROM area WHERE nombre_area = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", strtoupper($nombre));
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function existeNombreEnOtro($nombre, $codigoActual) {
        $sql = "SELECT 1 FROM area WHERE nombre_area = ? AND codigo != ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", strtoupper($nombre), $codigoActual);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    private function limpiarEspacios($texto) {
        return trim(preg_replace('/\s+/', ' ', $texto));
    }

}
?>