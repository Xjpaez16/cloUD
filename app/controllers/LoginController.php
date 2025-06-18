<?php

class LoginController
{
    private $estudianteDAO;
    private $tutorDAO;
    private $administradorDAO;

    public function __construct()
    {
        require_once(__DIR__ . '/models/DAO/EstudianteDAO.php');
        require_once(__DIR__ . '/models/DAO/TutorDAO.php');
        require_once(__DIR__ . '/models/DAO/AdministradorDAO.php');

        $this->estudianteDAO = new EstudianteDAO();
        $this->tutorDAO = new TutorDAO();
        $this->administradorDAO = new AdministradorDAO();
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
                if ($estudiante && password_verify($password, $estudiante->getContrasena())) { // Se agregó $estudiante &&
                    session_start();
                    $_SESSION['usuario'] = $estudiante;
                    $_SESSION['rol'] = 'estudiante';
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/student&session=success');
                    exit;
                } else {
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=1');
                    error_log('Error de inicio de sesión: contraseña incorrecta para el correo ' . $email); // Mensaje corregido
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
                    error_log('Error de inicio de sesión: contraseña incorrecta para el correo ' . $email);
                    exit;
                }
            }

            // Si es administrador
            if ($this->administradorDAO->comprobarCorreo($email)) {
                $administrador = $this->administradorDAO->validarLogin($email);
                if ($administrador && password_verify($password, $administrador->getContrasena())) {
                    session_start();
                    $_SESSION['usuario'] = $administrador;
                    $_SESSION['rol'] = 'administrador';
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/admin&session=success');
                    exit;
                }
                 else {
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=1');
                    error_log('Error de inicio de sesión: contraseña incorrecta para el correo ' . $email);
                    exit;
                }
            }

            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=3');
            exit;
        } else {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login');
            exit;
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . 'index.php?url=RouteController/home');
        exit;
    }
}