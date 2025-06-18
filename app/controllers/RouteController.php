<?php
class RouteController extends Controller
{
    public function index()
    {
        $this->view('home');
    }

    public function materials()
    {
        $this->view('materials');
    }

    public function login()
    {
        $this->view('login'); // muestra la vista login.php
    }

    public function register()
    {
        $this->view('register'); // muestra la vista login.php
    }

    public function studentregister()
    {
        require_once(__DIR__ . '/RegisterController.php');
        $registerController = new RegisterController();
        $registerController->viewcarrers(); // muestra la vista de studentregister.php
    }

    public function tutorregister()
    {
        require_once(__DIR__ . '/RegisterController.php');
        $registerController = new RegisterController();
        $registerController->viewareas(); // muestra la vista tutorregister.php
    }

    public function student()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Verifica si el usuario está logueado y es estudiante
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'estudiante') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit();
        }
        $this->view('student'); // muestra la vista student.php
    }

    public function tutor()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Verifica si el usuario está logueado y es tutor
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'tutor') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit();
        }
        $this->view('tutor'); // muestra la vista student.php
    }

    public function admin()
    {
        // Se asegura que la sesión se inicie antes de usar $_SESSION
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Verifica si el usuario está logueado y es administrador
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit();
        }
        $this->view('admin');
    }

    public function manageAdmins()
    {
        // Se asegura que la sesión se inicie antes de usar $_SESSION
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Verifica si el usuario está logueado y es administrador
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit();
        }
        require_once(__DIR__ . '/AdminController.php'); // Incluimos el nuevo controlador
        $adminController = new AdminController();
        $adminController->manageAdmins(); // Llama al método para gestionar administradores (CRUD)
    }

    // Rutas para las operaciones CRUD de administradores (POST requests)
    public function addAdmin()
    {
        require_once(__DIR__ . '/AdminController.php');
        $adminController = new AdminController();
        $adminController->addAdmin();
    }

    public function editAdmin()
    {
        require_once(__DIR__ . '/AdminController.php');
        $adminController = new AdminController();
        $adminController->editAdmin();
    }

    public function deleteAdmin()
    {
        require_once(__DIR__ . '/AdminController.php');
        $adminController = new AdminController();
        $adminController->deleteAdmin();
    }


    public function editTutor()
    {
        require_once(__DIR__ . '/TutorController.php'); // muestra la vista editTutor.php
        $TutorController = new TutorController();
        $TutorController->viewAreasChecked(); // muestra las areas
    }

    public function editStudent()
    {
        require_once(__DIR__ . '/StudentController.php'); // muestra la vista editStudent.php
        $StudentController = new StudentController();
        $StudentController->viewcarrers(); // muestra las carreras
    }

    public function resetPassword()
    {
        $this->view('resetpassword'); // muestra la vista resetpassword.php
    }

    public function changePassword()
    {
        $this->view('changepassword'); // muestra la vista changepassword.php
    }
}