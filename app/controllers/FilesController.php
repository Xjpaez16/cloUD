<?php 
    class FilesController{
        private $ProfesorDAO;
        private $areaDAO;

        private $materiaDAO;

        public function __construct()
            {
               require_once(__DIR__ . '/models/DAO/ProfesorDAO.php');
               require_once(__DIR__ . '/models/DAO/AreaDAO.php');
               require_once(__DIR__ . '/models/DAO/MateriaDAO.php');
             
               $this->ProfesorDAO = new ProfesorDAO;
               $this->areaDAO = new AreaDAO;
               $this->materiaDAO = new MateriaDAO;
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

        
    
    
    }


?>