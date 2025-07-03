<?php
class StudentController
{
    private $studentDAO;
    private $studentDTO;
    private $validation;
    private $carrerDAO;
    private $disponibilidadDAO;
    private $tutorDAO;
    private $tutoriaDAO;

    public function __construct()
    {
        require_once(__DIR__ . '/models/DAO/EstudianteDAO.php');
        require_once(__DIR__ . '/models/DTO/EstudianteDTO.php');
        require_once(__DIR__ . '/models/DAO/CarreraDAO.php');
        require_once(__DIR__ . '/models/DAO/DisponibilidadDAO.php');
        require_once(__DIR__ . '/models/DAO/TutorDAO.php');
        require_once(__DIR__ . '/utils/validation.php');
        require_once(__DIR__ . '/models/DAO/TutoriaDAO.php');
        require_once(__DIR__ . '/models/DAO/MotivoDAO.php');

        $this->studentDAO = new EstudianteDAO();
        $this->studentDTO = new EstudianteDTO();
        $this->validation = new validation();
        $this->carrerDAO = new CarreraDAO();
        $this->disponibilidadDAO = new DisponibilidadDAO(); 
        $this->tutorDAO = new TutorDAO();
        $this->tutoriaDAO = new TutoriaDAO();
        $this->motivoDAO = new MotivoDAO();
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
    
    public function displayTutorSearch()
    {
        // Obtener áreas para el select
        require_once(__DIR__ . '/models/DAO/AreaDAO.php');
        $areaDAO = new AreaDAO();
        $areas = $areaDAO->listarea();
        
        // Pasar datos básicos a la vista
        $data = [
            'areas' => $areas,
            'BASE_URL' => BASE_URL
        ];
        
        extract($data);
        require __DIR__ . '/../../view/student/search_tutors.php';
    }
    
    public function filterTutorsAjax()
    {
        // Obtener parámetros de filtro
        $filtros = [
            'area' => $_GET['area'] ?? null,
            'rating' => $_GET['rating'] ?? null
        ];
        
        error_log("Filtros recibidos en filterTutorsAjax: " . print_r($filtros, true));
        
        // Obtener tutores con filtros
        $tutorsAvailable = $this->disponibilidadDAO->getAvailableTutorsWithAreas($filtros);
        
        error_log("Tutores encontrados: " . count($tutorsAvailable));
        
        // Pasar datos al partial
        $data = [
            'tutorsAvailable' => $tutorsAvailable,
            'filtros' => $filtros
        ];
        
        extract($data);
        require __DIR__ . '/../../view/student/tutors_list.php';
        exit;
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
    public function viewMyTutorials() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $estudiante = $_SESSION['usuario'] ?? null;
        if (!$estudiante) {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }
        
        // Obtener todas las tutorías para el calendario
        $tutorias = $this->tutoriaDAO->getalltutorialbystudent($estudiante->getCodigo());
        $tutorias_json = array_map(function ($tutoria) {
            return [
                'fecha' => $tutoria->getFecha(),
                'hora_inicio' => $tutoria->getHora_inicio(),
                'hora_fin' => $tutoria->getHora_fin(),
                'cod_estado' => $tutoria->getCod_estado(),
            ];
        }, $tutorias);
            
            // Obtener tutorías pendientes para el modal
            $tutoriasPendientes = $this->tutoriaDAO->getTutoriasPendientes($estudiante->getCodigo());
            
            // Obtener motivos de cancelación
            $motivoDAO = new MotivoDAO();
            $motivos = $motivoDAO->listarMotivos();
            
            // Pasar todos los datos a la vista
            include __DIR__ . '/../../view/student/viewmytutorial.php';
    }


    /**
     * Muestra el panel de cancelación de tutorías
     */
    public function showCancelationPanel() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $estudiante = $_SESSION['usuario'] ?? null;
        if (!$estudiante) {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }
        
        // Obtener tutorías pendientes
        $tutoriasPendientes = $this->tutoriaDAO->getTutoriasPendientes($estudiante->getCodigo());
        
        // Obtener motivos de cancelación
        $motivoDAO = new MotivoDAO();
        $motivos = $motivoDAO->listarMotivos();
        
        // Incluir vista parcial
        include __DIR__ . '/../../view/student/cancelation_panel.php';
    }
    
    /**
     * Procesa la cancelación de una tutoría
     */
    public function processCancelation() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        try {
            $idTutoria = $_POST['id_tutoria'] ?? null;
            $motivo = $_POST['motivo'] ?? null;
            
            if (empty($idTutoria) || empty($motivo)) {
                throw new Exception("Datos incompletos para cancelar la tutoría.");
            }
            
            $this->tutoriaDAO->cancelarTutoriaConMotivo($idTutoria, $motivo);
            
            $_SESSION['success_message'] = "Tutoría cancelada correctamente.";
            
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
        }
        
        header('Location: ' . BASE_URL . 'index.php?url=RouteController/viewMyTutorial');
        exit;
    }
    
    
}
?>