<?php
    class RegisterController
    {
        private $estudianteDAO;
        private $tutorDAO;
        private $estudianteDTO;
        private $tutorDTO;
        public function __construct()
        {
            require_once(__DIR__ . '/models/DAO/EstudianteDAO.php');
            require_once(__DIR__ . '/models/DAO/TutorDAO.php');
            
            $this->estudianteDAO = new EstudianteDAO();
            $this->tutorDAO = new TutorDAO();

        }
        //selecionar el rol del usuario, si es estudiante o tutor
        public  function role()
{
            $role = isset($_GET['role']) ? $_GET['role'] : null;
            //verifica si el rol es estudiante o tutor
            if ($role === "estudiante") {
                $role = "estudiante";
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/studentregister');
                
            } elseif ($_GET === "tutor") {
                $role = "tutor";
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/tutorregister');
            }
            
            return $role;
        }
        //registro de usuario
        public function register()
        {
            require_once(__DIR__ . '/models/DTO/EstudianteDTO.php');
            require_once(__DIR__ . '/models/DTO/TutorDTO.php');

            $this->estudianteDTO = new EstudianteDTO();
            $this->tutorDTO = new TutorDTO();

            $role = $this->role();
            if ($role === "estudiante") {
                $this->estudianteDAO->create($this->estudianteDTO);
            } elseif ($role === "tutor") {
                $this->tutorDAO->create($this->tutorDTO);
            } else {
                // Si no se selecciona un rol, redirige a la página de registro
                header('Location: ' . BASE_URL . 'AuthController/register');
            }
            
        }
    }
?>