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
    
    public function editTutor()
    {
        require_once(__DIR__ . '/TutorController.php');// muestra la vista editTutor.php
        $TutorController = new TutorController();
        $TutorController->viewAreasChecked(); // muestra las areas
    }
    
    public function editStudent()
    {
        require_once(__DIR__ . '/StudentController.php');// muestra la vista editStudent.php
        $StudentController = new StudentController();
        $StudentController->viewcarrers(); // muestra las carreras
    }
}
