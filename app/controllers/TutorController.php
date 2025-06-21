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
    
    public function showAvailabilityForm()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'tutor') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }
        
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
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'tutor') {
            error_log("Acceso no autorizado");
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("Método incorrecto: " . $_SERVER['REQUEST_METHOD']);
            header("HTTP/1.1 405 Method Not Allowed");
            exit;
        }
        
        error_log("Datos recibidos: " . print_r($_POST, true));
        
        $cod_tutor = $_SESSION['usuario']->getCodigo();
        $id_dia = $_POST['dia'] ?? null;
        $hora_inicio = $_POST['hora_inicio'] ?? null;
        $hora_fin = $_POST['hora_fin'] ?? null;
        
        // Validación mejorada con mensajes específicos
        if (empty($id_dia) || empty($hora_inicio) || empty($hora_fin)) {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/registerAvailability&error=3'); // Campos vacíos
            exit;
        }
        
        if (!$this->validateTimeInterval($hora_inicio, $hora_fin)) {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/registerAvailability&error=1'); // Intervalo inválido
            exit;
        }
        
        $horarioDTO = new HorarioDTO(null, $id_dia, $cod_tutor, $hora_inicio, $hora_fin);
        $horarioId = $this->horarioDAO->create($horarioDTO);
        
        if (!$horarioId) {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/registerAvailability&error=2'); // Error BD
            exit;
        }
        
        $this->registerTimeSlots($cod_tutor, $id_dia, $hora_inicio, $hora_fin, $horarioId);
        header('Location: ' . BASE_URL . 'index.php?url=RouteController/viewAvailability&success=1');
        exit;
    }
    
    public function viewAvailability()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $tutor = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
        if (!$tutor) {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }
        
        $disponibilidad = $this->disponibilidadDAO->getByTutor($tutor->getCodigo());
        include __DIR__ . '/../../view/tutor/availability_view.php';
    }
    
    private function validateTimeInterval($hora_inicio, $hora_fin)
    {
        $inicio = new DateTime($hora_inicio);
        $fin = new DateTime($hora_fin);
        
        // Validar que la hora final sea mayor que la inicial
        if ($fin <= $inicio) {
            return false;
        }
        
        // Validar que el intervalo sea al menos 1 hora
        $diff = $fin->diff($inicio);
        return ($diff->h >= 1 || $diff->days > 0);
    }
    
    private function registerTimeSlots($cod_tutor, $id_dia, $hora_inicio, $hora_fin, $horarioId)
    {
        $inicio = new DateTime($hora_inicio);
        $fin = new DateTime($hora_fin);
        
        // Validar que el intervalo sea mínimo 1 hora
        if ($inicio->diff($fin)->h < 1 && $inicio->diff($fin)->i == 0) {
            throw new Exception("El intervalo mínimo debe ser de 1 hora");
        }
        
        // Calcular todas las fechas futuras para este día de la semana
        $fechas = $this->calculateFutureDatesForDay($id_dia, 4); // 4 semanas adelante
        
        foreach ($fechas as $fecha) {
            $currentStart = clone $inicio;
            $currentEnd = clone $currentStart;
            $currentEnd->add(new DateInterval('PT1H')); // Añadir 1 hora
            
            while ($currentEnd <= $fin) {
                $this->disponibilidadDAO->create(
                    $cod_tutor,
                    $currentStart->format('H:i:s'),
                    $currentEnd->format('H:i:s'),
                    $fecha,
                    $horarioId,
                    1 // Estado disponible
                    );
                
                // Mover al siguiente bloque
                $currentStart = clone $currentEnd;
                $currentEnd->add(new DateInterval('PT1H'));
            }
            
            // Registrar el último bloque si queda tiempo restante
            if ($currentStart < $fin) {
                $this->disponibilidadDAO->create(
                    $cod_tutor,
                    $currentStart->format('H:i:s'),
                    $fin->format('H:i:s'),
                    $fecha,
                    $horarioId,
                    1
                    );
            }
        }
    }
    
    private function calculateDateForDay($id_dia)
    {
        $diasSemana = [
            1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday',
            4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday'
        ];
        
        $fecha = new DateTime('next ' . ($diasSemana[$id_dia] ?? 'Monday'));
        return $fecha->format('Y-m-d');
    }
    
    private function calculateFutureDatesForDay($id_dia, $weeksAhead = 4)
    {
        $diasSemana = [
            1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday',
            4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday'
        ];
        
        $dayName = $diasSemana[$id_dia] ?? 'Monday';
        $dates = [];
        $today = new DateTime();
        
        for ($i = 0; $i < $weeksAhead; $i++) {
            $date = new DateTime("next $dayName +$i weeks");
            $dates[] = $date->format('Y-m-d');
        }
        
        return $dates;
    }
}
?>