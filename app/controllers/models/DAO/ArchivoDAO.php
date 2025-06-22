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
                $stm = "INSERT INTO archivo (id,ruta,cod_profesor,cod_estudiante,cod_tutor,cod_estado,id_tipo,id_materia,tamaño) VALUES (?,?,?,?,?,?,?,?,?)";
                $stm = $this->conn->prepare($stm);
                $stm->bind_param(
                    'isiiiiiis',
                    $this->$archivoDTO->getId(),
                    $this->$archivoDTO->getRuta(),
                    $this->$archivoDTO->getCod_profesor(),
                    $this->$archivoDTO->getCod_estudiante(),
                    $this->$archivoDTO->getCod_tutor(),
                    $this->$archivoDTO->getCod_estado(),
                    $this->$archivoDTO->getId_tipo(),
                    $this->$archivoDTO->getId_materia(),
                    $this->$archivoDTO->getTamaño() 
                );
                return $stm->execute();
            }catch(Exception $e){
                error_log('Error en crear ArchivoDAO: ' . $e->getMessage());
                return false;
            }
        }
        


    }
?>