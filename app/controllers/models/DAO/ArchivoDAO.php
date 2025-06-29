<?php 
require_once __DIR__ . '/../DTO/ArchivoDTO.php';


    class ArchivoDAO{
        private $conn;

        public function __construct() {
            require_once(__DIR__ . '/../../../../core/Conexion.php');
            $conexion = new Conexion();
            $this->conn= $conexion->getConexion();
        }
        
        public function create(ArchivoDTO $archivoDTO) {
            try{
                $stm = "INSERT INTO archivo (nombre,ruta,cod_profesor,cod_estudiante,cod_tutor,cod_area,cod_estado,id_tipo,id_materia,tamaño) VALUES (?,?,?,?,?,?,?,?,?,?)";
                $stm = $this->conn->prepare($stm);
                $nombre = $archivoDTO->getNombre();
                $ruta = $archivoDTO->getRuta();
                $cod_profesor = $archivoDTO->getCod_profesor();
                $cod_estudiante = $archivoDTO->getCod_estudiante();
                $cod_tutor = $archivoDTO->getCod_Tutor();
                $cod_area = $archivoDTO->getCod_area();
                $cod_estado = $archivoDTO->getCod_estado();
                $id_tipo = $archivoDTO->getId_tipo();
                $id_materia = $archivoDTO->getId_materia();
                $tamaño = $archivoDTO->getTamano();

                $stm->bind_param(
                    'ssiiiiiiis',
                    $nombre,
                    $ruta,
                    $cod_profesor,
                    $cod_estudiante,
                    $cod_tutor,
                    $cod_area,
                    $cod_estado,
                    $id_tipo,
                    $id_materia,
                    $tamaño
                    
                );
                return $stm->execute();
            }catch(Exception $e){
                error_log('Error en crear ArchivoDAO: ' . $e->getMessage());
                return false;
            }
        }
        public  function verificartipo($tipo){
            $id_tipo = null;
            try{
                $sql = "SELECT id FROM tipo_archivo WHERE nombre_tipo = ?";
                $stm = $this->conn->prepare($sql);
                $stm->bind_param('s',$tipo);
                $stm->execute();
                $stm->bind_result($id_tipo);
                if ($stm->fetch()) {
                    return $id_tipo; 
                } else {
                    return null; 
                }
               
                
            }catch(Exception $e){
                error_log('Error en verificar tipo ArchivoDAO: ' . $e->getMessage());
                return false;
            }
        }
        public function obtenertipo($id_tipo){
            $nombreTipo = null;
            try{
                $sql = "SELECT nombre_tipo FROM tipo_archivo WHERE id = ?";
                $stm = $this->conn->prepare($sql);
                $stm->bind_param('i',$id_tipo);
                $stm->execute();
                $stm->bind_result($nombreTipo);
                if ($stm->fetch()) {
                    return $nombreTipo; 
                } else {
                    return null; 
                }
               
                
            }catch(Exception $e){
                error_log('Error en verificar tipo ArchivoDAO: ' . $e->getMessage());
                return false;
            }
        }
        public function obtenerarea($cod_area){
            $nombreArea = null;
            try{
                $sql = "SELECT a.nombre_area FROM archivo ar 
                JOIN area a ON ar.cod_area = a.codigo WHERE ar.cod_area = ?";
                $stm = $this->conn->prepare($sql);
                $stm->bind_param('i',$cod_area);
                $stm->execute();
                $stm->bind_result($nombreArea);
                if ($stm->fetch()) {
                    return $nombreArea; 
                } else {
                    return null; 
                }
               
                
            }catch(Exception $e){
                error_log('Error en verificar tipo ArchivoDAO: ' . $e->getMessage());
                return false;
            }
        }
        public function obtenerprofesor($codigo){
            $nombreProfesor = null;
            try{
                $sql = "SELECT p.nombre FROM archivo ar 
                JOIN profesor p ON ar.cod_profesor = p.codigo WHERE ar.cod_profesor = ?";
                $stm = $this->conn->prepare($sql);
                $stm->bind_param('i',$codigo);
                $stm->execute();
                $stm->bind_result($nombreProfesor);
                if ($stm->fetch()) {
                    return $nombreProfesor; 
                } else {
                    return null; 
                }
               
                
            }catch(Exception $e){
                error_log('Error en verificar tipo ArchivoDAO: ' . $e->getMessage());
                return false;
            }
        }
         public function obtenermateria($cod_materia){
            $nombreMateria = null;
            try{
                $sql = "SELECT m.nombre_materia FROM archivo ar 
                JOIN materia m ON ar.id_materia = m.id WHERE ar.id_materia = ?";
                $stm = $this->conn->prepare($sql);
                $stm->bind_param('i',$cod_materia);
                $stm->execute();
                $stm->bind_result($nombreMateria);
                if ($stm->fetch()) {
                    return $nombreMateria; 
                } else {
                    return null; 
                }
               
                
            }catch(Exception $e){
                error_log('Error en verificar tipo ArchivoDAO: ' . $e->getMessage());
                return false;
            }
        }

        public function allfiles($archivosS3){
            try{
                $sql = "SELECT * FROM archivo WHERE cod_estado = 7 AND nombre = ?";
                $archivos = [];
                foreach($archivosS3 as $s3archivos){
                     $stm= $this->conn->prepare($sql);
                     $rutas3 = $s3archivos->getUrl();
                     $nombre = $s3archivos->getNombre();
                     $stm->bind_param('s',$nombre);
                     $stm->execute();
                     $result=$stm->get_result();

                    while($row=$result->fetch_assoc()){
                        $archivo = new ArchivoDTO();
                        $archivo->setNombre($row['nombre']);
                        $archivo->setRuta($s3archivos->getUrl());
                        $archivo->setCod_profesor($row['cod_profesor']);
                        $archivo->setCod_estudiante($row['cod_estudiante']);
                        $archivo->setCod_Tutor($row['cod_tutor']);
                        $archivo->setCod_area($row['cod_area']);
                        $archivo->setCod_estado($row['cod_estado']);
                        $archivo->setId_tipo($row['id_tipo']);
                        $archivo->setId_materia($row['id_materia']);
                        $archivo->setTamano($s3archivos->getTamaño());
                        $archivos[] = $archivo;
                        error_log("Archivos :" .$archivo->getRuta());
                        error_log("Archivos s3 :" .$s3archivos->getUrl());

                           
                    }
                    $stm->close();
                }
                 return $archivos;
                 
            }catch(Exception $e){
                error_log('Error en obtener archivos ArchivoDAO: ' . $e->getMessage());
                return false;
            }
        }
        public function getMyFilesStudent($cod_estudiante,$archivosS3){
            try{
                $sql = "SELECT * FROM archivo WHERE cod_estudiante = ? AND nombre = ?";
                $myfiles = [];
             foreach($archivosS3 as $s3archivos){
                     $stm= $this->conn->prepare($sql);
                     $rutas3 = $s3archivos->getUrl();
                     $nombre = $s3archivos->getNombre();
                     $stm->bind_param('is',$cod_estudiante,$nombre);
                     $stm->execute();
                     $result=$stm->get_result();

                    while($row=$result->fetch_assoc()){
                        $archivo = new ArchivoDTO();
                        $archivo->setId($row['id']);
                        $archivo->setRuta($s3archivos->getUrl());
                        $archivo->setCod_profesor($row['cod_profesor']);
                        $archivo->setCod_estudiante($row['cod_estudiante']);
                        $archivo->setCod_Tutor($row['cod_tutor']);
                        $archivo->setCod_area($row['cod_area']);
                        $archivo->setCod_estado($row['cod_estado']);
                        $archivo->setId_tipo($row['id_tipo']);
                        $archivo->setId_materia($row['id_materia']);
                        $archivo->setTamano($s3archivos->getTamaño());
                        $myfiles[] = $archivo;
                        error_log("Archivos :" .$archivo->getRuta());
                        error_log("Archivos s3 :" .$s3archivos->getUrl());

                           
                    }
                    $stm->close();
                }
                 return $myfiles;
                 
            }catch(Exception $e){
                error_log('Error en obtener archivos Archivos por estudiante: ' . $e->getMessage());
                return false;
            }
        }
          public function getMyFilesTutor($cod_tutor,$archivosS3){
            try{
                $sql = "SELECT * FROM archivo WHERE cod_tutor = ? AND nombre = ?";
                $myfiles = [];
             foreach($archivosS3 as $s3archivos){
                     $stm= $this->conn->prepare($sql);
                     $rutas3 = $s3archivos->getUrl();
                     $nombre = $s3archivos->getNombre();
                     $stm->bind_param('is',$cod_tutor,$nombre);
                     $stm->execute();
                     $result=$stm->get_result();

                    while($row=$result->fetch_assoc()){
                        $archivo = new ArchivoDTO();
                        $archivo->setId($row['id']);
                        $archivo->setRuta($s3archivos->getUrl());
                        $archivo->setCod_profesor($row['cod_profesor']);
                        $archivo->setCod_estudiante($row['cod_estudiante']);
                        $archivo->setCod_Tutor($row['cod_tutor']);
                        $archivo->setCod_area($row['cod_area']);
                        $archivo->setCod_estado($row['cod_estado']);
                        $archivo->setId_tipo($row['id_tipo']);
                        $archivo->setId_materia($row['id_materia']);
                        $archivo->setTamano($s3archivos->getTamaño());
                        $myfiles[] = $archivo;
                        error_log("Archivos :" .$archivo->getRuta());
                        error_log("Archivos s3 :" .$s3archivos->getUrl());

                           
                    }
                    $stm->close();
                }
                 return $myfiles;
                 
            }catch(Exception $e){
                error_log('Error en obtener archivos Archivos por estudiante: ' . $e->getMessage());
                return false;
            }
        }
        public function updateFile($id,$archivoDTO){
            try{
                $sql = "UPDATE archivo SET cod_profesor = ?, cod_area = ?, cod_estado = ?, id_materia = ? WHERE id = ?";
                $stm = $this->conn->prepare($sql);
                $cod_profesor = $archivoDTO->getCod_profesor();
                $cod_area = $archivoDTO->getCod_area();
                $cod_estado = $archivoDTO->getCod_estado();
                $id_materia = $archivoDTO->getId_materia();
                
                $stm->bind_param(
                    'iiiii',
                    $cod_profesor,
                    $cod_area,
                    $cod_estado,
                    $id_materia,
                    $id
                ); 
                error_log("cod_profesor: " . $cod_profesor);
        error_log("cod_area: " . $cod_area);
        error_log("cod_estado: " . $cod_estado);
        error_log("id_materia: " . $id_materia);
        error_log("id (WHERE): " . $id);
                return $stm->execute();
            }catch(Exception $e){
                error_log('Error en actualizar archivo ArchivoDAO: ' . $e->getMessage());
                return false;
            
            }
        }
    }
?>