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
                $stm = "INSERT INTO archivo (ruta,cod_profesor,cod_estudiante,cod_tutor,cod_area,cod_estado,id_tipo,id_materia,tamaño) VALUES (?,?,?,?,?,?,?,?,?)";
                $stm = $this->conn->prepare($stm);
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
                    'siiiiiiis',
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
            try{
                $sql = "SELECT id FROM tipo_archivo WHERE nombre_tipo = ?";
                $sql = $this->conn->prepare($sql);
                $sql->bind_param('s',$tipo);
                return $sql->execute();
                
            }catch(Exception $e){
                error_log('Error en verificar tipo ArchivoDAO: ' . $e->getMessage());
                return false;
            }
        }
        public function allfiles($archivosS3){
            try{
                $sql = "SELECT * FROM archivo WHERE cod_estado = 7 AND ruta = ?";
                $archivos = [];
                foreach($archivosS3 as $s3archivos){
                     $stm= $this->conn->prepare($sql);
                     $rutas3 = $s3archivos->getUrl();
                     $stm->bind_param('s',$rutas3);
                     $stm->execute();
                     $result=$stm->get_result();

                    while($row=$result->fetch_assoc()){
                        $archivo = new ArchivoDTO();
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
                 if ($archivos === false) {
    error_log( "❌ Error al consultar la base de datos.");
} elseif (empty($archivos)) {
    error_log("⚠️ La consulta no devolvió resultados.");
} else {
    error_log( "✅ Archivos encontrados: " . count($archivos) . "<br><br>");

    foreach ($archivos as $archivo) {
        error_log( "Nombre: " . $archivo->getRuta() . "<br>");
        error_log( "Área: " . $archivo->getCod_area() . "<br>");
        error_log( "Profesor: " . $archivo->getCod_profesor() . "<br>");
        error_log( "Materia: " . $archivo->getId_materia() . "<br>");
        error_log("--------------------------<br>");
    }
}
            }catch(Exception $e){
                error_log('Error en obtener archivos ArchivoDAO: ' . $e->getMessage());
                return false;
            }
        }
    }
?>