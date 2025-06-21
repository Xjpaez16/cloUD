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
        
        try {
            $cod_tutor = $_SESSION['usuario']->getCodigo();
            $id_dia = $_POST['dia'] ?? null;
            $hora_inicio = $_POST['hora_inicio'] ?? null;
            $hora_fin = $_POST['hora_fin'] ?? null;
            
            // Validaciones básicas
            if (empty($id_dia) || empty($hora_inicio) || empty($hora_fin)) {
                throw new Exception("Todos los campos son requeridos", 3);
            }
            
            if (!$this->validateTimeInterval($hora_inicio, $hora_fin)) {
                throw new Exception("El intervalo de tiempo debe ser de al menos 1 hora", 1);
            }
            
            // Crear el horario base
            $horarioDTO = new HorarioDTO(null, $id_dia, $cod_tutor, $hora_inicio, $hora_fin);
            $horarioId = $this->horarioDAO->create($horarioDTO);
            
            if (!$horarioId) {
                throw new Exception("Error al registrar el horario", 2);
            }
            
            // Registrar los bloques de disponibilidad
            $this->registerTimeSlots($cod_tutor, $id_dia, $hora_inicio, $hora_fin, $horarioId);
            
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/viewAvailability&success=1');
            exit;
        } catch (Exception $e) {
            error_log('Error en registerAvailability: ' . $e->getMessage());
            exit;
        }
    }
    
    public function viewAvailability() {
        require_once(__DIR__ . '/TutorController.php');
        $tutorController = new TutorController();
        $tutorController->viewAvailability();
    }
    
    // RouteController.php
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
}
?>