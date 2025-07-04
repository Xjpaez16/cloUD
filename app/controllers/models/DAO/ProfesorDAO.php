<?php
require_once(__DIR__ . '/../DTO/ProfesorDTO.php');
    class ProfesorDAO{

        private $conn;

        public function __construct()
        {
            require_once(__DIR__ . '/../../../../core/Conexion.php');
            $conexion = new Conexion();
            $this->conn = $conexion->getConexion();
        }
        public function listteachers(){
            try {
               $sql = "SELECT * FROM profesor";
               $result = $this->conn->query($sql);     
               $profesores = [];
               
               while($row = $result->fetch_assoc()){
                    $dto = new ProfesorDTO();
                    $dto->setCod($row['codigo']);
                    $dto->setNom($row['nombre']);  
                    $profesores [] = $dto;
               }
               return $profesores;
            }catch(Exception $e){
                echo "Error al traer los profesores: " . $e->getMessage();
                return [];
            }
        }
    }
?>