<?php
    class LoginController
    {
        private $estudianteDAO;
        private $tutorDAO;
       

        public function __construct()
        {
            
            require_once(__DIR__ . '/models/DAO/EstudianteDAO.php');
            require_once(__DIR__ . '/models/DAO/TutorDAO.php');
            
            $this->estudianteDAO = new EstudianteDAO();
            $this->tutorDAO = new TutorDAO();
           
        }

        
        public function login()
        {

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $estudiante = $this->estudianteDAO->validarLogin($email, $password);
            //rellenar bd con campos de prueba para poder completar el controlador
            
            if ($estudiante && password_verify($password, $estudiante->getContrasena())) {
                session_start();
                $_SESSION['usuario'] = $estudiante;
                $_SESSION['rol'] = 'estudiante';
                $ruta = base64_encode('dashboard');
                header('Location: ' . BASE_URL . '?url=' . $ruta);
                exit;
            }
            $tutor = $this->tutorDAO->validarLogin($email, $password);
            if ($tutor && password_verify($password, $tutor->getContrasena())) {
                session_start();
                $_SESSION['usuario'] = $tutor;
                $_SESSION['rol'] = 'tutor';
                $ruta = base64_encode('dashboard');
                header('Location: ' . BASE_URL . '?url=' . $ruta);
                exit;
            }else{
                // Si falla el login, redirige con error para Toastify y vuelve a AuthController/login usando BASE_URL
                header('Location: ' . BASE_URL . 'AuthController/login?error=1');
                exit;
            }
            
            }
        }

      
        
        
    }
?>