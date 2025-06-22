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
    
    public function __construct()
    {
        require_once(__DIR__ . '/models/DAO/TutorDAO.php');
        require_once(__DIR__ . '/models/DTO/TutorDTO.php');
        require_once(__DIR__ . '/utils/validation.php');
        require_once(__DIR__ . '/models/DAO/AreaDAO.php');
        require_once(__DIR__ . '/models/DAO/HorarioDAO.php');
        require_once(__DIR__ . '/models/DAO/DiaDAO.php');
        require_once(__DIR__ . '/models/DAO/DisponibilidadDAO.php');
        
        $this->tutorDAO = new TutorDAO();
        $this->tutorDTO = new TutorDTO();
        $this->validation = new validation();
        $this->areaDAO = new AreaDAO();
        $this->areaDTO = new AreaDTO();
        $this->horarioDAO = new HorarioDAO();
        $this->diaDAO = new DiaDAO();
        $this->disponibilidadDAO = new DisponibilidadDAO();
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
}
?>