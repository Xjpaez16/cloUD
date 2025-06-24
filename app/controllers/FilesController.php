<?php 
    class FilesController{
        private $ProfesorDAO;
        private $areaDAO;

        private $materiaDAO;
        private $archivoDAO;
        private $s3;
        private $archivoDTO;


        public function __construct()
            {
               require_once(__DIR__ . '/models/DAO/ProfesorDAO.php');
               require_once(__DIR__ . '/models/DAO/AreaDAO.php');
               require_once(__DIR__ . '/models/DAO/MateriaDAO.php');
               require_once(__DIR__ .'/models/DAO/S3DAO.php');
               require_once(__DIR__ .'/models/DAO/ArchivoDAO.php');
               require_once(__DIR__ .'/models/DTO/ArchivoDTO.php'); 
               require_once(__DIR__ .'/models/DTO/EstudianteDTO.php'); 

               $this->ProfesorDAO = new ProfesorDAO;
               $this->areaDAO = new AreaDAO;
               $this->materiaDAO = new MateriaDAO;
               $this->archivoDAO = new ArchivoDAO;
               $this->s3 = new S3DAO;
               $this->archivoDTO = new ArchivoDTO;
            }
        public function viewteachers(){
            $profesores = $this->ProfesorDAO->listteachers();
            return $profesores;
        }
       public function viewareas(){
                $areas = $this->areaDAO->listarea();
                return $areas;
              
        }
        public function viewmaterias(){
                $materias = $this->materiaDAO->listmaterias();
                return $materias;
        }
        public function viewfiles(){
            $archivoDAO= new ArchivoDAO();
            $archivosS3  = $this->s3->viewfiles();
            $archivos = $this->archivoDAO->allfiles($archivosS3);
            require_once(__DIR__ . '../../../view/viewallfiles.php'); 
        }
        public function uploadfiles () {
            if(session_status()==PHP_SESSION_NONE){
                session_start();
            }
            $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
            $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
            if($rol=='estudiante'){
                if($_SERVER['REQUEST_METHOD']=='POST' && isset($_FILES['archivo'])){
                    $s3 = new S3DAO();
                    $resultado = $s3->uploadFile($_FILES['archivo']);
                    $profesor =$_POST['profesor'];
                    $area = $_POST['area'];
                    $materia = $_POST['materia'];
                    $id_tipo = $this->archivoDAO->verificartipo($resultado->getTipo());
                    $this->archivoDTO->setRuta($resultado->getUrl());
                    $this->archivoDTO->setTamano($resultado->getTamaño());
                    $this->archivoDTO->setCod_profesor($profesor);
                    $this->archivoDTO->setCod_area($area);
                    $this->archivoDTO->setId_materia($materia);
                    $this->archivoDTO->setCod_estudiante($usuario->getCodigo());
                    $this->archivoDTO->setCod_Tutor(null);
                    $this->archivoDTO->setCod_estado(7);
                    if($id_tipo){
                        $this->archivoDTO->setId_tipo($id_tipo);
                    }else{
                        header('Location: ' . BASE_URL . 'index.php?url=RouteController/uploadfiles&error=1');
                    }

                    error_log("Mostrando :" .$this->archivoDTO->getRuta());
                    error_log("Mostrando :" .$this->archivoDTO->getTamano());
                    error_log("Mostrando :" .$this->archivoDTO->getCod_profesor());
                    error_log("Mostrando :" .$this->archivoDTO->getCod_area());
                    error_log("Mostrando :" .$this->archivoDTO->getId_materia());
                    error_log("Mostrando :" .$this->archivoDTO->getCod_estudiante());
                    error_log("Mostrando :" .$this->archivoDTO->getCod_Tutor());
                    error_log("Mostrando :" .$this->archivoDTO->getCod_estado());
                    error_log("Mostrando :" .$this->archivoDTO->getId_tipo());
                    $upFile = $this->archivoDAO->create($this->archivoDTO);
                    if($resultado &&  $upFile){
                        header('Location: ' . BASE_URL . 'index.php?url=RouteController/dashboardfiles&success=1');
                        exit; 
                    }
                }
            }
        }

    }

?>