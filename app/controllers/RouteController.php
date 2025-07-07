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

        $this->view('student'); // muestra la vista student.php
    }

    public function tutor()
    {
        $this->view('tutor'); // muestra la vista student.php
    }

    public function admin()
    {
        session_start();
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }
        require_once(__DIR__ . '/../../view/admin.php');
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

    public function registerAvailability()
    {
        require_once(__DIR__ . '/TutorController.php');
        $tutorController = new TutorController();
        $tutorController->showAvailabilityForm();
    }

    public function viewAvailability()
    {
        require_once(__DIR__ . '/TutorController.php');
        $tutorController = new TutorController();
        $tutorController->viewAvailability();
    }

    public function showAvailabilityForm()
    {
        require_once(__DIR__ . '/TutorController.php');
        $tutorController = new TutorController();
        $tutorController->showAvailabilityForm();
    }

    public function processAvailability()
    {
        require_once(__DIR__ . '/TutorController.php');
        $tutorController = new TutorController();
        $tutorController->registerAvailability();
    }
    
    public function showTutorSearch()
    {
        require_once(__DIR__ . '/StudentController.php');
        $studentController = new StudentController();
        $studentController->displayTutorSearch();
    }
    
    public function filterTutorsAjax()
    {
        require_once(__DIR__ . '/StudentController.php');
        $studentController = new StudentController();
        $studentController->filterTutorsAjax();
    }
    
    public function processTutorRequest() {
        require_once(__DIR__ . '/StudentController.php');
        $studentController = new StudentController();
        $studentController->handleTutorRequest();
    }   
    
    public function viewProfileStudent() {
        require_once __DIR__ . '/StudentController.php';
        $controller = new StudentController();
        $controller->viewProfile();
    }
    
    public function viewProfileTutor() {
        require_once __DIR__ . '/TutorController.php';
        $controller = new TutorController();
        $controller->viewProfile();
    }
    
    public function viewSupport()
    {
        require_once(__DIR__ . '/adminController.php');
        $adminController = new AdminController();
        $admin = $adminController->obtenerAdmin();
        $adminNombre = $admin ? $admin->getNombre() : "Administrador";
        $adminCorreo = $admin ? $admin->getCorreo() : "soporte@udistrital.edu.co";
        require __DIR__ . '/../../view/viewSupport.php';
    }
    
    public function viewFAQ()
    {
        require_once(__DIR__ . '/AdminController.php');
        $adminController = new AdminController();
        $admin = $adminController->obtenerAdmin();
        $adminNombre = $admin ? $admin->getNombre() : "Administrador";
        $adminCorreo = $admin ? $admin->getCorreo() : "soporte@udistrital.edu.co";
        require __DIR__ . '/../../view/viewFAQ.php';
    }

    public function requestTutorial() {
        require_once(__DIR__ . '/TutoriaController.php');
        $tutorId = $_GET['tutor_id'] ?? null;
        $horarioId = $_GET['horario_id'] ?? null;
        $tutoriaController = new TutoriaController();
        $tutoriaController->mostrarFormularioSolicitud($tutorId, $horarioId);
        
    }

    public function processRequest() {
        require_once(__DIR__ . '/TutoriaController.php');
        $tutoriaController = new TutoriaController();
        $tutoriaController->procesarSolicitudTutoria();
    }
    
    public function showTutoriaConfirmation() {
        require_once(__DIR__ . '/TutoriaController.php');
        $tutoriaController = new TutoriaController();
        $tutoriaController->mostrarConfirmacionTutoria($_GET['id'] ?? null);
    }
    
    public function solicitudesTutor() {
        require_once(__DIR__ . '/TutorController.php');
        $tutorController = new TutorController();
        $tutorController->solicitudesTutoria();
    }
    
    public function procesarAprobacionTutoria() {
        require_once(__DIR__ . '/TutorController.php');
        $tutorController = new TutorController();
        $tutorController->procesarAprobacion();
    }
    
    
    public function showTutorRequests() {
        require_once(__DIR__ . '/TutoriaController.php');
        $tutoriaController = new TutoriaController();
        $tutoriaController->mostrarSolicitudesTutor();
    }
    
    public function aprobarTutoria() {
        require_once(__DIR__ . '/TutoriaController.php');
        $tutoriaController = new TutoriaController();
        $tutoriaController->procesarAprobacion();
    }
    
    public function rechazarTutoria() {
        require_once(__DIR__ . '/TutoriaController.php');
        $tutoriaController = new TutoriaController();
        $tutoriaController->procesarRechazo();
    }
    public function viewMyTutorial(){
        require_once(__DIR__ . '/StudentController.php');
        //$this->processRequest();
        $studentController = new StudentController();
        $studentController->viewMyTutorials();
    }

    public function showCancelationPanel() {
        require_once(__DIR__ . '/StudentController.php');
        $studentController = new StudentController();
        $studentController->showCancelationPanel();
    }
    
    public function processCancelation() {
        require_once(__DIR__ . '/StudentController.php');
        $studentController = new StudentController();
        $studentController->processCancelation();
    }
    public function processCancelationTutor() {
        require_once(__DIR__ . '/TutorController.php');
        $tutorController = new TutorController();
        $tutorController->processCancelation();
    }

    public function editAvailability() {
        require_once(__DIR__ . '/TutorController.php');
        $tutorController = new TutorController();
        $tutorController->mostrarFormularioEdicion();
    }
    
    public function updateAvailability() {
        require_once(__DIR__ . '/TutorController.php');
        $tutorController = new TutorController();
        $tutorController->actualizarDisponibilidad();
    }
    
    public function deleteAvailability() {
        require_once(__DIR__ . '/TutorController.php');
        $tutorController = new TutorController();
        $tutorController->eliminarDisponibilidad();
    }
    public function dashboardfiles()
    {
        $this->view('dashboardfiles');
    }
    public function uploadfiles()
    {
        require_once(__DIR__ . '/FilesController.php');

        $FilesController = new FilesController();
        $profesores = $FilesController->viewteachers();
        require_once(__DIR__ . '../../../view/uploadfiles.php');
    }
    public function viewallfiles()
    {
        require_once(__DIR__ . '/FilesController.php');

        $filesController = new FilesController();
        $profesores = $filesController->viewteachers(); // retorna array
        $areas = $filesController->viewareas();
        $materias = $filesController->viewmaterias();
        $archivos = $filesController->viewfiles();
        $archivoDAO = new ArchivoDAO();
        require_once(__DIR__ . '../../../view/viewallfiles.php'); // muestra la vista de viewallfiles.php

    }
    public function viewmyfilesStudent()
    {
        require_once(__DIR__ . '/FilesController.php');

        $filesController = new FilesController();
        $profesores = $filesController->viewteachers(); // retorna array
        $areas = $filesController->viewareas();
        $materias = $filesController->viewmaterias();
        $archivosest = $filesController->myfiles();
        $archivoDAO = new ArchivoDAO();
        require_once(__DIR__ . '../../../view/viewMyFiles.php'); // muestra la vista de viewmyfiles.php
    }
       
}
