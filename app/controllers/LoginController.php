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
            $email=$_POST['email'];
            $password = $_POST['password'];
            $estudiante = $this->estudianteDAO->validarLogin($email);
            
$correoExiste = $this->estudianteDAO->comprobarCorreo($email);
error_log("¿Correo existe? " . ($correoExiste ? 'Sí' : 'No'));
                   //verifica si el estudiante existe 
            if($this->estudianteDAO->comprobarCorreo($email)) {
                if (!$this->estudianteDAO->verificarEstado($email)) {
                    // Si el estudiante no está activo, redirige al login con error
                    
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=2');
                    exit;
                }else{
                //verificar si el estudiante existe y si la contraseña es correcta
                    if ($password == $estudiante->getContrasena() ){
                        session_start();
                        $_SESSION['usuario'] = $estudiante;
                        $_SESSION['rol'] = 'estudiante';
                        echo "Login exitoso";
                        header('Location: ' . BASE_URL . 'index.php?url=RouteController/student');
                        exit;
                    }

                    $tutor = $this->tutorDAO->validarLogin($email, $password);
                    if ($tutor && password_verify($password, $tutor->getContrasena())) {
                        session_start();
                        $_SESSION['usuario'] = $tutor;
                        $_SESSION['rol'] = 'tutor';
                         
                        header('Location: ' . BASE_URL . 'index.php?ruta=RouteController/tutor' );
                        exit;
                    }

                    // Si ninguno es válido, redirige al login con error
                    
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=1');
                    exit;
                }
        }else{
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=3');
             exit;
        }
        
            }else{
                // Si no es una solicitud POST, redirige al login
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/login');
                exit;
            }
        }

      
        
        
    }
?>