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
            $sql = "INSERT INTO tutor (codigo, nombre, correo, contrasena, calificacion_general, respuesta_preg, cod_estado) VALUES (?, ?, ?, ?,?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $codigo = $tutor->getCodigo();
            $nombre = $tutor->getNombre();
            $correo = $tutor->getCorreo();
            $contrasena = $tutor->getContrasena();
            $calificacion_general = $tutor->getCalificacion_general();
            $respuesta_preg = $tutor->getRespuesta_preg();
            $cod_estado = $tutor->getCod_estado();
            $stmt->bind_param(
                'isssisi',
                $codigo,
                $nombre,
                $correo,
                $contrasena,
                $calificacion_general,
                $respuesta_preg,
                $cod_estado
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
            error_log('Error en getByCodigo TutorDAO: ' . $e->getMessage());
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
    public function update($codigo, TutorDTO $tutor)
    {
        try {
            $sql = "UPDATE tutor SET nombre = ?, correo = ?, contrasena = ?, calificacion_general = ?, respuesta_preg = ?, cod_estado = ? WHERE codigo = ?";
            $stmt = $this->conn->prepare($sql);
            $nombre = $tutor->getNombre();
            $correo = $tutor->getCorreo();
            $contrasena = $tutor->getContrasena();
            $calificacion_general = $tutor->getCalificacion_general();
            $respuesta_preg = $tutor->getRespuesta_preg();
            $cod_estado = $tutor->getCod_estado();
            $stmt->bind_param(
                'sssdssi',
                $nombre,
                $correo,
                $contrasena,
                $calificacion_general,
                $respuesta_preg,
                $cod_estado,
                $codigo
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
                    $row['respuesta_preg'],
                    $row['calificacion_general'],
                    $row['cod_estado']
                );
            }
            return null;
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
}
