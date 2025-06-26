<?php
class StudentController
{
    private $studentDAO;
    private $studentDTO;
    private $validation;
    private $carrerDAO;
    private $disponibilidadDAO;
    private $tutorDAO;

    public function __construct()
    {
        require_once(__DIR__ . '/models/DAO/EstudianteDAO.php');
        require_once(__DIR__ . '/models/DTO/EstudianteDTO.php');
        require_once(__DIR__ . '/models/DAO/CarreraDAO.php');
        require_once(__DIR__ . '/models/DAO/DisponibilidadDAO.php');
        require_once(__DIR__ . '/models/DAO/TutorDAO.php');
        require_once(__DIR__ . '/utils/validation.php');
        
        $this->studentDAO = new EstudianteDAO();
        $this->studentDTO = new EstudianteDTO();
        $this->validation = new validation();
        $this->carrerDAO = new CarreraDAO();
        $this->disponibilidadDAO = new DisponibilidadDAO(); 
        $this->tutorDAO = new TutorDAO();
    }
    

    public function viewcarrers()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $estudiante = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
        if (!$estudiante) {
            error_log('No hay sesión activa de estudiante.');
            // Puedes redirigir o mostrar un error amigable aquí si lo deseas
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }

        $carreras = $this->carrerDAO->listcarrers();
        require_once(__DIR__ . '/../../view/editStudent.php');
    }

    public function updateProfile()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $student = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
        if (!$student) {
            error_log('No hay sesión activa de estudiante.');
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }

        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $carrera = $_POST['carrer'];
        error_log("Carrera seleccionada: " . $carrera);
        // Validar los datos

        if (!$this->validation->validateEmail($correo)) {
            error_log('Correo inválido: ' . $correo);
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/editStudent&error=2');
            exit;
        }

        // Actualizar el tutor
        $student->setNombre($nombre);
        $student->setCorreo($correo);
        $student->setCod_carrera($carrera);

        if ($this->studentDAO->update($student->getCodigo(), $student)) {
            $_SESSION['usuario'] = $student; // Actualizar la sesión
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/editStudent&success=1');
            exit;
        } else {
            error_log('Error al actualizar el perfil del estudiante.');
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/editStudent&error=1');
            exit;
        }
    }
    
    public function displayTutorSearch() {
        error_log("Iniciando búsqueda de tutores...");
        
        // Validar si DAO está inicializado correctamente
        if (!isset($this->disponibilidadDAO) || !is_object($this->disponibilidadDAO)) {
            error_log("Error: DisponibilidadDAO no inicializado o no es objeto");
            throw new Exception("DisponibilidadDAO no está inicializado correctamente");
        }
        
        // Obtener tutores disponibles
        $tutorsAvailable = $this->disponibilidadDAO->getAvailableTutors();
        
        // Verificar y loguear resultados
        $countTutors = is_array($tutorsAvailable) ? count($tutorsAvailable) : 0;
        error_log("Tutores recibidos en Controller: $countTutors");
        
        if ($countTutors > 0) {
            error_log("Estructura del primer tutor:");
            error_log(print_r($tutorsAvailable[0], true));
        } else {
            error_log("No se encontraron tutores disponibles.");
        }
        
        // Función para convertir ID de día a nombre (aunque ya recibes `day_name`, por si acaso)
        $diaHelper = function($idDia) {
            $dias = [
                1 => 'Lunes',
                2 => 'Martes',
                3 => 'Miércoles',
                4 => 'Jueves',
                5 => 'Viernes',
                6 => 'Sábado',
                7 => 'Domingo'
            ];
            return $dias[$idDia] ?? 'Día no especificado';
        };
        
        // Renderizar vista
        require __DIR__ . '/../../view/student/search_tutors.php';
    }
    
    
    private function checkStudentSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'estudiante') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }
    }
    
    public function handleTutorRequest()
    {
        $this->checkStudentSession();
        
        $tutorCode = $_GET['code'] ?? null;
        $dayId = $_GET['day'] ?? null;  // Corrección: usamos dayId, no date
        $startTime = $_GET['start'] ?? null;
        $endTime = $_GET['end'] ?? null;
        
        // Validación corregida
        if (!$tutorCode || !$dayId || !$startTime || !$endTime) {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/showTutorSearch&error=invalid_params');
            exit;
        }
        
        $result = $this->processTutorRequest($tutorCode, $dayId, $startTime, $endTime);
        
        if ($result) {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/showTutorSearch&success=request_created');
        } else {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/showTutorSearch&error=request_failed');
        }
        exit;
    }
    
    
    private function processTutorRequest($tutorCode, $date, $startTime, $endTime)
    {
        // Validar disponibilidad
        if (!$this->disponibilidadDAO->checkAvailability($tutorCode, $date, $startTime, $endTime)) {
            return false;
        }
        
        $studentCode = $_SESSION['usuario']->getCodigo();
        return $this->tutorDAO->createTutoringRequest(
            $studentCode,
            $tutorCode,
            $date,
            $startTime,
            $endTime
            );
    }
    
    public function viewProfile() {
        session_start();
        
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'estudiante') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit();
        }
        
        $codigoEstudiante = $_SESSION['usuario']->getCodigo(); 
        
        $dao = new EstudianteDAO();
        $studentProfile = $dao->getStudentProfileById($codigoEstudiante);
        
        if (!$studentProfile) {
            error_log("Error: Perfil no encontrado para el estudiante con código $codigoEstudiante");
            $_SESSION['error'] = "No se pudo cargar tu perfil.";
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/home');
            exit();
        }
        
        require __DIR__ . '/../../view/student/viewProfileStudent.php';
        
    }
    
    
}
?>