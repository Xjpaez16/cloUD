<?php
class TutorController
{
    private $tutorDAO;
    private $tutorDTO;
    private $validation;
    private $areaDAO;
    private $areaDTO;
    private $horarioDAO;
    private $diaDAO;
    private $disponibilidadDAO;
    
    private $tutoriaDAO;
    public function __construct()
    {
        require_once(__DIR__ . '/models/DAO/TutorDAO.php');
        require_once(__DIR__ . '/models/DTO/TutorDTO.php');
        require_once(__DIR__ . '/utils/validation.php');
        require_once(__DIR__ . '/models/DAO/AreaDAO.php');
        require_once(__DIR__ . '/models/DAO/HorarioDAO.php');
        require_once(__DIR__ . '/models/DAO/DiaDAO.php');
        require_once(__DIR__ . '/models/DAO/DisponibilidadDAO.php');
        require_once(__DIR__ . '/models/DAO/TutoriaDAO.php');

        $this->tutorDAO = new TutorDAO();
        $this->tutorDTO = new TutorDTO();
        $this->validation = new validation();
        $this->areaDAO = new AreaDAO();
        $this->areaDTO = new AreaDTO();
        $this->horarioDAO = new HorarioDAO();
        $this->diaDAO = new DiaDAO();
        $this->disponibilidadDAO = new DisponibilidadDAO();
        $this->tutoriaDAO = new TutoriaDAO();
    }
    
    // Métodos existentes para gestión de perfil
    public function viewAreasChecked()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $tutor = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
        if (!$tutor) {
            error_log('No hay sesión activa de tutor.');
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }
        
        $areas = $this->areaDAO->listarea();
        $checkedAreas = $this->tutorDAO->getAreasByTutor($tutor->getCodigo());
        require_once(__DIR__ . '/../../view/editTutor.php');
    }
    
    public function updateProfile()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $tutor = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
        if (!$tutor) {
            error_log('No hay sesión activa de tutor.');
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login');
            exit;
        }
        
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $areas = isset($_POST['area']) ? $_POST['area'] : [];
        
        if (!$this->validation->validateEmail($correo)) {
            error_log('Correo inválido: ' . $correo);
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/editTutor&error=2');
            exit;
        }
        
        $tutor->setNombre($nombre);
        $tutor->setCorreo($correo);
        
        if ($this->tutorDAO->update($tutor->getCodigo(), $tutor)) {
            $this->tutorDAO->updateAreasByTutor($tutor->getCodigo(), $areas);
            $_SESSION['usuario'] = $tutor;
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/editTutor&success=1');
            exit;
        } else {
            error_log('Error al actualizar el perfil del tutor.');
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/editTutor&error=1');
            exit;
        }
    }
    
    // Métodos para gestión de disponibilidad (mejorados pero manteniendo funcionalidad)
    public function showAvailabilityForm()
    {
        $this->validateTutorSession();
        
        // Limpiar parámetros de error si existen
        if (isset($_GET['error'])) {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/registerAvailability');
            exit;
        }
        
        $dias = $this->diaDAO->getAll();
        include __DIR__ . '/../../view/tutor/availability_form.php';
    }
    
    public function registerAvailability()
    {
        $this->validateTutorSession();
        
        if(!$this->validatePostMethod()){
        error_log("Datos recibidos: " . print_r($_POST, true));
        
        $cod_tutor = $_SESSION['usuario']->getCodigo();
        $id_dia = $_POST['dia'] ?? null;
        $hora_inicio = $_POST['hora_inicio'] ?? null;
        $hora_fin = $_POST['hora_fin'] ?? null;
        
        $this->validateAvailabilityData($id_dia, $hora_inicio, $hora_fin);
        
        $horarioId = $this->createHorario($cod_tutor, $id_dia, $hora_inicio, $hora_fin);
        $this->registerTimeSlots($cod_tutor, $hora_inicio, $hora_fin, $horarioId);
        
        header('Location: ' . BASE_URL . 'index.php?url=RouteController/viewAvailability&success=1');
        exit;
        }
    }
    
    public function viewAvailability()
    {
        $this->validateTutorSession();
        
        $tutor = $_SESSION['usuario'];
        $disponibilidad = $this->disponibilidadDAO->getByTutor($tutor->getCodigo());
        include __DIR__ . '/../../view/tutor/availability_view.php';
    }
    
    // Métodos auxiliares privados (mejor organizados)
    private function validateTutorSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'tutor') {
            error_log("Acceso no autorizado");
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }
    }
    
    private function validatePostMethod()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("Método incorrecto: " . $_SERVER['REQUEST_METHOD']);
            header("HTTP/1.1 405 Method Not Allowed");
            exit;
        }
    }
    
    private function validateAvailabilityData($id_dia, $hora_inicio, $hora_fin)
    {
        if (empty($id_dia) || empty($hora_inicio) || empty($hora_fin)) {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/registerAvailability&error=3');
            exit;
        }
        
        if (!$this->validateTimeInterval($hora_inicio, $hora_fin)) {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/registerAvailability&error=1');
            exit;
        }
    }
    
    private function createHorario($cod_tutor, $id_dia, $hora_inicio, $hora_fin)
    {
        $horarioDTO = new HorarioDTO(null, $id_dia, $cod_tutor, $hora_inicio, $hora_fin);
        $horarioId = $this->horarioDAO->create($horarioDTO);
        
        if (!$horarioId) {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/registerAvailability&error=2');
            exit;
        }
        
        return $horarioId;
    }
    
    private function validateTimeInterval($hora_inicio, $hora_fin)
    {
        $inicio = new DateTime($hora_inicio);
        $fin = new DateTime($hora_fin);
        
        if ($fin <= $inicio) {
            return false;
        }
        
        $diff = $fin->diff($inicio);
        return ($diff->h >= 1 || $diff->days > 0);
    }
    
    private function registerTimeSlots($cod_tutor, $hora_inicio, $hora_fin, $horarioId)
    {
        $inicio = new DateTime($hora_inicio);
        $fin = new DateTime($hora_fin);
        
        if ($inicio->diff($fin)->h < 1 && $inicio->diff($fin)->i == 0) {
            throw new Exception("El intervalo mínimo debe ser de 1 hora");
        }
        
        $currentStart = clone $inicio;
        $currentEnd = clone $currentStart;
        $currentEnd->add(new DateInterval('PT1H'));
        
        while ($currentEnd <= $fin) {
            $this->createDisponibilidad($cod_tutor, $currentStart, $currentEnd, $horarioId);
            $currentStart = clone $currentEnd;
            $currentEnd->add(new DateInterval('PT1H'));
        }
        
        if ($currentStart < $fin) {
            $this->createDisponibilidad($cod_tutor, $currentStart, $fin, $horarioId);
        }
    }
    
    private function createDisponibilidad($cod_tutor, $inicio, $fin, $horarioId)
    {
        $this->disponibilidadDAO->create(
            $cod_tutor,
            $inicio->format('H:i:s'),
            $fin->format('H:i:s'),
            $horarioId,
            7 // Estado disponible
            );
    }
    
    public function viewProfile() {
        session_start();
        
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'tutor') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit();
        }
        
        $codigoTutor = $_SESSION['usuario']->getCodigo();
        
        $dao = new TutorDAO();
        $tutorProfile = $dao->getTutorProfileById($codigoTutor);
        
        if (!$tutorProfile) {
            error_log("Error: Perfil no encontrado para tutor $codigoTutor");
            $_SESSION['error'] = "No se pudo cargar tu perfil.";
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/home');
            exit();
        }
        
        require __DIR__ . '/../../view/tutor/viewProfileTutor.php';
    }
    
    /**
     * Verifica que el usuario sea un tutor con sesión activa
     */
    protected function verificarSesionTutor() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'tutor') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=unauthorized');
            exit;
        }
    }
    
    /**
     * Muestra las solicitudes de tutoría pendientes
     */
    public function solicitudesTutoria() {
    $this->verificarSesionTutor();

    try {
        require_once(__DIR__ . '/models/DAO/TutoriaDAO.php');
        require_once(__DIR__ . '/models/DAO/MotivoDAO.php');

        $tutoriaDAO = new TutoriaDAO();
        $motivoDAO = new MotivoDAO();

        $codTutor = $_SESSION['usuario']->getCodigo();

        
        $solicitudes = $tutoriaDAO->obtenerSolicitudesPendientes($codTutor);

       
        $tutorias = $tutoriaDAO->getTutoriasfinish($codTutor);

        
        $motivos = $motivoDAO->listarMotivos();

        // Cargar la vista
        $viewPath = __DIR__ . '/../../view/tutor/solicitudes_tutorias.php';
        if (!file_exists($viewPath)) {
            throw new Exception("Vista no encontrada: $viewPath");
        }

        // Variables disponibles para la vista
        require_once $viewPath;

    } catch (Exception $e) {
        error_log("Error en solicitudesTutoria: " . $e->getMessage());
        $_SESSION['error_message'] = "Error al cargar las solicitudes";
        header('Location: ' . BASE_URL . 'index.php?url=RouteController/dashboardTutor');
        exit;
    }
}

    public function procesarAprobacion() {
        $this->verificarSesionTutor();
        
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception("Método no permitido");
            }
            
            $idTutoria = (int)$_POST['id_tutoria'];
            $accion = $_POST['accion'];
            
            $tutoriaDAO = new TutoriaDAO();
            
            if ($accion === 'aprobar') {
                $result = $tutoriaDAO->aprobarTutoria($idTutoria);
                $mensaje = 'success_tutoria_aprobada';
            } elseif ($accion === 'rechazar') {
                $codMotivo = (int)$_POST['cod_motivo'];
                $result = $tutoriaDAO->rechazarTutoria($idTutoria, $codMotivo);
                $mensaje = 'success_tutoria_rechazada';
            } else {
                throw new Exception("Acción inválida");
            }
            
            if (!$result) {
                throw new Exception("Error al procesar la solicitud");
            }
            
            header('Location: ' . BASE_URL . 'index.php?url=TutorController/solicitudesTutoria&success='.$mensaje);
            exit;
            
        } catch (Exception $e) {
            error_log("Error en procesarAprobacion: " . $e->getMessage());
            header('Location: ' . BASE_URL . 'index.php?url=TutorController/solicitudesTutoria&error=1');
            exit;
        }
    }
    
    /**
     * Procesa la eliminación de disponibilidad
     */
    public function eliminarDisponibilidad() {
        $this->verificarSesionTutor();
        
        try {
            $codTutor = $_POST['cod_tutor'] ?? null;
            $horaI = $_POST['hora_i'] ?? null;
            $horaFn = $_POST['hora_fn'] ?? null;
            $idHorario = $_POST['id_horario'] ?? null;
            
            if (empty($codTutor) || empty($horaI) || empty($horaFn) || empty($idHorario)) {
                throw new Exception("Datos incompletos para eliminar");
            }
            
            $resultado = $this->disponibilidadDAO->eliminarDisponibilidad($codTutor, $horaI, $horaFn, $idHorario);
            
            if (!$resultado) {
                throw new Exception("No se pudo eliminar la disponibilidad");
            }
            
            $_SESSION['success_message'] = "Disponibilidad eliminada correctamente";
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/viewAvailability&success=3');
            exit;
            
        } catch (Exception $e) {
            error_log("Error en eliminarDisponibilidad: " . $e->getMessage());
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/viewAvailability&error=1');
            exit;
        }
    }
    
    
    /**
     * Muestra el formulario de edición
     */
    public function mostrarFormularioEdicion() {
        $this->verificarSesionTutor();
        
        try {
            $codTutor = $_SESSION['usuario']->getCodigo();
            $idHorario = $_GET['id_horario'] ?? null;
            
            if (empty($idHorario)) {
                throw new Exception("Parámetro incompleto");
            }
            
            $disponibilidad = $this->disponibilidadDAO->obtenerPorId($codTutor, $idHorario);
            
            if (!$disponibilidad) {
                throw new Exception("Disponibilidad no encontrada");
            }
            
            $dias = $this->diaDAO->getAll();
            include __DIR__ . '/../../view/tutor/edit_availability.php';
            
        } catch (Exception $e) {
            error_log("Error en mostrarFormularioEdicion: " . $e->getMessage());
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/viewAvailability&error=2');
            exit;
        }
    }
    
    
    
    
    
    
    /**
     * Procesa la actualización de disponibilidad
     */
    public function actualizarDisponibilidad() {
        $this->verificarSesionTutor();
        
        $id_horario = $_POST['id_horario'] ?? null;
        $id_dia = $_POST['dia'] ?? null;
        $hora_inicio = $_POST['hora_inicio'] ?? null;
        $hora_fin = $_POST['hora_fin'] ?? null;
        $cod_tutor = $_POST['cod_tutor'] ?? null;
        
        if (!$id_horario || !$id_dia || !$hora_inicio || !$hora_fin || !$cod_tutor) {
            header("Location: " . BASE_URL . "index.php?url=RouteController/viewAvailability&error=1");
            exit();
        }
        
        if (!$this->validateTimeInterval($hora_inicio, $hora_fin)) {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/viewAvailability&error=4');
            exit;
        }
        
        // Actualizas la tabla horario
        $horarioDTO = new HorarioDTO($id_horario, $id_dia, $cod_tutor, $hora_inicio, $hora_fin);
        $resultado = $this->horarioDAO->update($horarioDTO);
        
        if (!$resultado) {
            header("Location: " . BASE_URL . "index.php?url=RouteController/viewAvailability&error=2");
            exit();
        }
        
        // Eliminamos bloques de disponibilidad actuales
        $this->disponibilidadDAO->eliminarPorHorario($cod_tutor, $id_horario);
        
        // Insertamos los nuevos bloques de disponibilidad por cada hora
        $this->registerTimeSlots($cod_tutor, $hora_inicio, $hora_fin, $id_horario);
        
        header("Location: " . BASE_URL . "index.php?url=RouteController/viewAvailability&success=2");
        exit();
    }
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
            error_log("Tutoría cancelada con éxito." . $idTutoria . $motivo);
            $_SESSION['success_message'] = "Tutoría cancelada correctamente.";
            
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
        }
        
        header('Location: ' . BASE_URL . 'index.php?url=RouteController/solicitudesTutor');
        exit;
    }
    public function processfinish(){
        $id_tutoria = $_POST['id_tutoria'] ?? null;
        
        if($this->tutoriaDAO->setfinishtutorial($id_tutoria)){
            header ('Location: ' . BASE_URL . 'index.php?url=RouteController/solicitudesTutor&success=1');
        }
    } 
}
    

?>