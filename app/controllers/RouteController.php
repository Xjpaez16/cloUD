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
        $this->view('admin'); // muestra la vista student.php
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

    public function showAvailabilityForm() {
        require_once(__DIR__ . '/TutorController.php');
        $tutorController = new TutorController();
        $tutorController->showAvailabilityForm();
    }
    
    public function processAvailability() {
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
        $adminController = new adminController();
        $admin = $adminController->obtenerAdmin();
        $adminNombre = $admin ? $admin->getNombre() : "Administrador";
        $adminCorreo = $admin ? $admin->getCorreo() : "soporte@udistrital.edu.co";
        require __DIR__ . '/../../view/viewSupport.php';
    }
    
    public function viewFAQ()
    {
        require_once(__DIR__ . '/adminController.php');
        $adminController = new adminController();
        $admin = $adminController->obtenerAdmin();
        $adminNombre = $admin ? $admin->getNombre() : "Administrador";
        $adminCorreo = $admin ? $admin->getCorreo() : "soporte@udistrital.edu.co";
        require __DIR__ . '/../../view/viewFAQ.php';
    }

    public function requestTutorial() {
        require_once(__DIR__ . '/TutoriaController.php');
        $tutoriaController = new TutoriaController();
        $tutoriaController->mostrarFormularioSolicitud($_GET['tutor_id'] ?? null,$_GET['horario_id'] ?? null);
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
    
    
}
?>