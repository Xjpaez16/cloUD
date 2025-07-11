<?php

class LoginController
{
    private $estudianteDAO;
    private $tutorDAO;
    private $adminDAO;
    private $tutoriaDAO;

    public function __construct()
    {
        require_once(__DIR__ . '/models/DAO/EstudianteDAO.php');
        require_once(__DIR__ . '/models/DAO/TutorDAO.php');
        require_once(__DIR__ . '/models/DAO/AdminDAO.php');
        require_once(__DIR__ . '/models/DAO/TutoriaDAO.php');
        
        $this->estudianteDAO = new EstudianteDAO();
        $this->tutorDAO = new TutorDAO();
        $this->adminDAO = new AdminDAO();
        $this->tutoriaDAO = new TutoriaDAO();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Si es estudiante
            if ($this->estudianteDAO->comprobarCorreo($email)) {
                if (!$this->estudianteDAO->verificarEstado($email)) {
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=2');
                    exit;
                }
                
                $estudiante = $this->estudianteDAO->validarLogin($email);
                
                if (password_verify($password, $estudiante->getContrasena())) {
                    session_start();
                    $_SESSION['usuario'] = $estudiante;
                    $_SESSION['rol'] = 'estudiante';
                    error_log ("cod_estudiante: " . $estudiante->getCodigo());
                    $tutoriasfinish = $this->tutoriaDAO->getTutoriasfinal($estudiante->getCodigo());
                    if(!empty($tutoriasfinish)){
                        $_SESSION['tutorias_a_calificar'] = $tutoriasfinish;
                    }
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/student&session=success');
                    exit;
                } else {
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=1');
                    error_log('Error de inicio de sesión: contraseña incorrecta para el correo ' . $estudiante->getContrasena());

                    exit;
                }
            }

            // Si es tutor
            if ($this->tutorDAO->comprobarCorreo($email)) {
                if (!$this->tutorDAO->verificarEstado($email)) {
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=2');
                    exit;
                }
                $tutor = $this->tutorDAO->validarLogin($email);

                if ($tutor && password_verify($password, $tutor->getContrasena())) {
                    session_start();
                    $_SESSION['usuario'] = $tutor;
                    $_SESSION['rol'] = 'tutor';
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/tutor&session=success');
                    exit;
                } else {
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=1');
                    error_log('Error de inicio de sesión: tutor no encontrado o contraseña incorrecta para el correo ' . $email);
                    exit;
                }
            }

            // Si es administrador
            $admin = $this->adminDAO->obtenerAdminPorCorreo($email);
            if ($admin && $password == $admin->getContrasena()) {
                session_start();
                $_SESSION['usuario'] = $admin;
                $_SESSION['rol'] = 'administrador';
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/admin&session=success');
                exit;
            }

            // Si no existe el correo en ninguna tabla
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=3');
            exit;
        } else {
            // Si no es una solicitud POST, redirige al login
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login');
            exit;
        }
    }
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        echo "<script>
            history.pushState(null, null, location.href);
            history.replaceState(null, null, location.href);
            window.location.href = '" . BASE_URL . "index.php?url=RouteController/login';
        </script>";
        exit;
    }
    }
