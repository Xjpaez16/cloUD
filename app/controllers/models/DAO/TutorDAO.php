<?php
require_once(__DIR__ . '/../DTO/TutorDTO.php');

class TutorDAO
{
    private $conn;

    public function __construct()
    {
        require_once(__DIR__ . '/../../../../core/Conexion.php');
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    // Crear tutor (la contraseña debe venir hasheada desde el controlador)
    public function create(TutorDTO $tutor)
    {
        try {
            $codigo = $tutor->getCodigo();
            $correo = $tutor->getCorreo();
            $nombre = $tutor->getNombre();

            $sql = "SELECT codigo FROM tutor WHERE codigo = ? OR correo = ? OR nombre = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iss", $codigo, $correo, $nombre);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return "duplicado";
            }

            $sql = "INSERT INTO tutor (codigo, nombre, correo, contrasena, calificacion_general, respuesta_preg, cod_estado) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                'isssdsi',
                $codigo,
                $nombre,
                $correo,
                $tutor->getContrasena(),
                $tutor->getCalificacion_general(),
                $tutor->getRespuesta_preg(),
                $tutor->getCod_estado()
            );
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error en crear TutorDAO: ' . $e->getMessage());
            return false;
        }
    }

    // Obtener tutor por código
    public function getid($codigo)
    {
        try {
            $sql = "SELECT * FROM tutor WHERE codigo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('i', $codigo);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return new TutorDTO(
                    $row['codigo'],
                    $row['nombre'],
                    $row['correo'],
                    $row['contrasena'],
                    $row['calificacion_general'],
                    $row['respuesta_preg'],
                    $row['cod_estado']
                );
            }
            return null;
        } catch (Exception $e) {
            error_log('Error en getid TutorDAO: ' . $e->getMessage());
            return null;
        }
    }



    // Obtener todos los tutores
    public function todos()
    {
        try {
            $sql = "SELECT * FROM tutor";
            $result = $this->conn->query($sql);
            $tutores = [];
            while ($row = $result->fetch_assoc()) {
                $tutores[] = new TutorDTO(
                    $row['codigo'],
                    $row['nombre'],
                    $row['correo'],
                    $row['contrasena'],
                    $row['calificacion_general'],
                    $row['respuesta_preg'],
                    $row['cod_estado']
                );
            }
            return $tutores;
        } catch (Exception $e) {
            error_log('Error en getAll TutorDAO: ' . $e->getMessage());
            return [];
        }
    }

    // Actualizar tutor
    public function update($codigoActual, TutorDTO $tutor)
    {
        try {
            $sql = "UPDATE tutor SET codigo = ?, nombre = ?, correo = ?, contrasena = ?, calificacion_general = ?, respuesta_preg = ?, cod_estado = ? WHERE codigo = ?";
            $stmt = $this->conn->prepare($sql);

            $codigoNuevo = $tutor->getCodigo();
            $nombre = $tutor->getNombre();
            $correo = $tutor->getCorreo();
            $contrasena = $tutor->getContrasena();
            $calificacion_general = $tutor->getCalificacion_general();
            $respuesta_preg = $tutor->getRespuesta_preg();
            $cod_estado = $tutor->getCod_estado();

            $stmt->bind_param(
                'ssssdssi',
                $codigoNuevo,
                $nombre,
                $correo,
                $contrasena,
                $calificacion_general,
                $respuesta_preg,
                $cod_estado,
                $codigoActual
            );

            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error en update TutorDAO: ' . $e->getMessage());
            return false;
        }
    }


    // Soft delete tutor (cambiar estado)
    public function softDelete($codigo, $nuevoEstado)
    {
        try {
            $sql = "UPDATE tutor SET cod_estado = ? WHERE codigo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ii', $nuevoEstado, $codigo);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error en softDelete TutorDAO: ' . $e->getMessage());
            return false;
        }
    }


    public function verificarEstado($email)
    {
        try {
            $sql = "SELECT cod_estado FROM tutor t 
                JOIN estado es ON t.cod_estado = es.codigo
                WHERE es.tipo_estado = 'Verificado' AND t.correo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return $row['cod_estado'] == 2;
            }
            return false;
        } catch (Exception $e) {
            error_log('Error en verificarEstado TutorDAO: ' . $e->getMessage());
            return false;
        }
    }
    // Validar login de tutor
    public function validarLogin($correo)
    {
        try {
            $sql = "SELECT * FROM tutor WHERE correo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('s', $correo);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return new TutorDTO(
                    $row['codigo'],
                    $row['nombre'],
                    $row['correo'],
                    $row['contrasena'],
                    $row['calificacion_general'],
                    $row['respuesta_preg'],
                    $row['cod_estado']
                );
            }else{
            return null;
            }
        } catch (Exception $e) {
            error_log('Error en validarLogin TutorDAO: ' . $e->getMessage());
            return null;
        }
    }

    // Registrar relacion tutor-areas
    public function insertarRelacion($codTutor, $codArea)
    {
        $sql = "INSERT INTO area_tutor (cod_tutor, cod_area) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error en prepare registrar relacion: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $codTutor, $codArea);
        return $stmt->execute();
    }

    //inserta cuantas veces areas sea necesario
    public function insertarAreasDeTutor($tutorDTO)
    {
        $codTutor = $tutorDTO->getCodigo();
        $areas = $tutorDTO->getAreas();

        foreach ($areas as $codArea) {
            $this->insertarRelacion($codTutor, $codArea);
        }
    }

    //comprobar correo
    public function comprobarCorreo($correo)
    {
        try {
            $sql = "SELECT * FROM tutor WHERE correo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('s', $correo);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->num_rows > 0; // Retorna true si existe, false si no
        } catch (Exception $e) {
            error_log('Error en comprobarCorreo TutorDAO: ' . $e->getMessage());
            return false;
        }
    }

    //comprobar rta_seguridad
    public function comprobarRtaSeguridad($correo, $respuesta_preg)
    {
        try {
            $sql = "SELECT * FROM tutor WHERE correo = ? AND respuesta_preg = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ss', $correo, $respuesta_preg);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->num_rows > 0; // Retorna true si existe, false si no
        } catch (Exception $e) {
            error_log('Error en comprobarRtaSeguridad TutorDAO: ' . $e->getMessage());
            return false;
        }
    }
    //cambiar contraseña
    public function cambiarContrasena($correo, $nuevaContrasena)
    {
        try {
            $sql = "UPDATE tutor SET contrasena = ? WHERE correo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ss', $nuevaContrasena, $correo);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error en cambiarContrasena TutorDAO: ' . $e->getMessage());
            return false;
        }
    }
    public function getAreasByTutor($codTutor)
    {
        try {
            $sql = "SELECT a.codigo, a.nombre_area
                    FROM area_tutor atu 
                    JOIN area a ON atu.cod_area = a.codigo 
                    WHERE atu.cod_tutor = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('i', $codTutor);
            $stmt->execute();
            $result = $stmt->get_result();
            $areas = [];
            while ($row = $result->fetch_assoc()) {
                $areas[] = [
                    'codigo' => $row['codigo'],
                    
                ];
                error_log('Area: ' . $row['nombre_area']);
            }
            
            return $areas;
        } catch (Exception $e) {
            error_log('Error en getAreasByTutor TutorDAO: ' . $e->getMessage());
            return [];
        }
    }
    public function updateAreasByTutor($codTutor, $areas)
    {
        try {
            // Primero eliminamos las áreas existentes
            $sqlDelete = "DELETE FROM area_tutor WHERE cod_tutor = ?";
            $stmtDelete = $this->conn->prepare($sqlDelete);
            $stmtDelete->bind_param('i', $codTutor);
            $stmtDelete->execute();

            // Luego insertamos las nuevas áreas
            foreach ($areas as $codArea) {
                $this->insertarRelacion($codTutor, $codArea);
            }
            return true;
        } catch (Exception $e) {
            error_log('Error en updateAreasByTutor TutorDAO: ' . $e->getMessage());
            return false;
        }
    }
    
    public function getTutorProfileById($codigo) {
        try {
            $sql = "SELECT t.codigo, t.nombre, t.correo, t.calificacion_general,
                       e.tipo_estado
                FROM tutor t
                JOIN estado e ON t.cod_estado = e.codigo
                WHERE t.codigo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $codigo);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
            
        } catch (Exception $e) {
            error_log("Error al obtener perfil del tutor: " . $e->getMessage());
            return null;
        }
    }
    
    public function obtenerTutoresFiltrados($filtroArea = null, $filtroRating = null) {
        try {
            $sql = "SELECT t.*,
                GROUP_CONCAT(DISTINCT a.nombre_area SEPARATOR ', ') AS areas_enseñanza,
                AVG(c.calificacion) AS rating_promedio
                FROM tutor t
                LEFT JOIN area_tutor at ON t.codigo = at.cod_tutor
                LEFT JOIN area a ON at.cod_area = a.codigo
                LEFT JOIN calificacion c ON t.codigo = c.cod_tutor
                WHERE t.cod_estado = 2"; // Solo tutores verificados
            
            $params = [];
            $types = '';
            
            // Aplicar filtros
            if ($filtroArea) {
                $sql .= " AND a.codigo = ?";
                $params[] = $filtroArea;
                $types .= 'i';
            }
            
            if ($filtroRating) {
                $sql .= " HAVING rating_promedio >= ?";
                $params[] = $filtroRating;
                $types .= 'i';
            } else {
                $sql .= " GROUP BY t.codigo";
            }
            
            $stmt = $this->conn->prepare($sql);
            
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            $tutores = [];
            while ($row = $result->fetch_assoc()) {
                $tutor = new TutorDTO(
                    $row['codigo'],
                    $row['nombre'],
                    $row['correo'],
                    null, // No necesitamos la contraseña
                    $row['calificacion_general'],
                    null, // No necesitamos respuesta de seguridad
                    $row['cod_estado']
                    );
                
                // Agregar información adicional
                $tutor->setAreas($row['areas_enseñanza']);
                $tutor->setCalificacion_general($row['rating_promedio'] ?? $row['calificacion_general']);
                
                $tutores[] = [
                    'tutor' => $tutor,
                    'rating' => $row['rating_promedio'] ?? 0,
                    'areas' => $row['areas_enseñanza'] ?? 'Sin áreas especificadas'
                ];
            }
            
            return $tutores;
        } catch (Exception $e) {
            error_log('Error en obtenerTutoresFiltrados: ' . $e->getMessage());
            return [];
        }
    }
    
    public function mostrarTutoresFiltrados() {
        require_once(__DIR__ . '/../DAO/AreaDAO.php');
        $areaDAO = new AreaDAO();
        
        // Obtener parámetros de filtro
        $filtroArea = $_GET['area'] ?? null;
        $filtroRating = $_GET['rating'] ?? null;
        
        // Obtener tutores con filtros
        $tutorsAvailable = $this->obtenerTutoresFiltrados($filtroArea, $filtroRating);
        $areas = $areaDAO->listarea();
        
        // Pasar datos a la vista
        $data = [
            'tutorsAvailable' => $tutorsAvailable,
            'areas' => $areas,
            'filtroArea' => $filtroArea,
            'filtroRating' => $filtroRating,
            'BASE_URL' => BASE_URL
        ];
        
        extract($data);
        require_once __DIR__ . '/../view/tutor/tutores_disponibles.php';
    }

    public function desactivarTutor($codigo) {
        $stmt = $this->conn->prepare("UPDATE tutor SET cod_estado = 3 WHERE codigo = ?");
        $stmt->bind_param("i", $codigo);
        return $stmt->execute();
    }

    public function activarTutor($codigo) {
        $stmt = $this->conn->prepare("UPDATE tutor SET cod_estado = 2 WHERE codigo = ?");
        $stmt->bind_param("i", $codigo);
        return $stmt->execute();
    }
    public function top3TutoresPorCalificacion()
    {
        try{
        $sql ="
            SELECT nombre, calificacion_general FROM tutor
            WHERE calificacion_general IS NOT NULL
            ORDER BY calificacion_general DESC LIMIT 3
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_NUM);
        }
        catch (Exception $e) {
            error_log('Error en top3TutoresPorCalificacion: ' . $e->getMessage());
            return [];
        }

    }
    public function obtenerCalificacion($cod_tutor){
        $calificacionbd = null;
        try {
            $sql = "SELECT calificacion_general FROM tutor WHERE codigo = ?";
            $stm = $this->conn->prepare($sql);
            $stm->bind_param('i', $cod_tutor);
            $stm->execute();
            $stm->bind_result($calificacionbd);
            if ($stm->fetch()) {
                return $calificacionbd;
            } else {
                return null;
            }
        } catch (Exception $e) {
            error_log('Error en traer la calificacion general: ' . $e->getMessage());
            return false;
        }
    }
    public function setCalificacion($calificacion,$cod_tutor){
        try{
            $sql = "UPDATE tutor SET calificacion_general = ? WHERE codigo = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ii', $calificacion,$cod_tutor);
            return $stmt->execute();
        }catch(Exception $e){
            error_log('Error en setCalificacion TutorDAO: ' . $e->getMessage());
            return false;
        }
    }

}
?>