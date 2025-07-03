<?php
require_once(__DIR__ . '/models/DTO/EstudianteDTO.php'); 
require_once(__DIR__ . '/models/DTO/TutorDTO.php');
require_once(__DIR__ . '/models/DTO/TutoriaDTO.php');
require_once(__DIR__ . '/models/DAO/TutoriaDAO.php');
require_once(__DIR__ . '/models/DAO/TutorDAO.php');
require_once(__DIR__ . '/models/DAO/MotivoDAO.php');
require_once(__DIR__ . '/models/DAO/EstadoDAO.php');
require_once(__DIR__ . '/utils/validation.php');
require_once(__DIR__ . '/models/DAO/HorarioDAO.php');
class TutoriaController {
    private $tutoriaDAO;
    private $tutorDAO;
    private $motivoDAO;
    private $estadoDAO;
    private $validation;
    private $horariodao;
    public function __construct() {
        $this->tutoriaDAO = new TutoriaDAO();
        $this->tutorDAO = new TutorDAO();
        $this->motivoDAO = new MotivoDAO();
        $this->estadoDAO = new EstadoDAO();
        $this->validation = new validation();
        $this->horariodao = new HorarioDAO();
    }
    
    /**
     * Muestra el formulario para solicitar tutoría
     */
    public function mostrarFormularioSolicitud($tutorId,$id_horario) {
        $this->verificarSesionEstudiante();
        
        try {
            $tutor = $this->tutorDAO->getid($tutorId);
            if (!$tutor) {
                throw new Exception("Tutor no encontrado");
            }
            
            $motivos = $this->motivoDAO->listarMotivos();
            
            // Preparar datos para la vista
            $data = [
                'tutor' => $tutor,
                'motivos' => $motivos,
                'BASE_URL' => BASE_URL
            ];
            
            // Verificar si la vista existe antes de requerirla
            $viewPath = __DIR__ . '/../../view/tutoria/solicitar_tutoria.php';
            if (!file_exists($viewPath)) {
                throw new Exception("Vista no encontrada: $viewPath");
            }
            error_log("id_horario : " . $id_horario);
            error_log("id_tutor : " . $tutorId);
            $horario=$this->horariodao->getscheduleById($tutorId, $id_horario);
            
            // Cargar la vista directamente
            require_once $viewPath;
            error_log("horario : ". $horario->getId_dia());
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/showTutorSearch&error=tutor_not_found');
            exit;
        }
    }
    /**
     * Procesa la solicitud de tutoría
     */
    public function procesarSolicitudTutoria() {
        $this->verificarSesionEstudiante();
        
        try {
            // Debug: Verificar datos recibidos
            error_log("Datos POST recibidos: " . print_r($_POST, true));
            
            // Validación básica
            if (empty($_POST['tutor_id']) || empty($_POST['fecha']) ||
                empty($_POST['hora_inicio']) || empty($_POST['hora_fin'])) {
                    throw new Exception("Todos los campos son requeridos");
                }
                
                // Preparar los datos de la tutoría
                $tutoria = new TutoriaDTO(
                    $_SESSION['usuario']->getCodigo(), // cod_estudiante
                    (int)$_POST['tutor_id'],          // cod_tutor
                    null,                             // id (se generará automáticamente)
                    $_POST['fecha'],                  // fecha
                    $_POST['hora_inicio'],            // hora_inicio
                    $_POST['hora_fin'],               // hora_fin
                    4,                                // cod_estado (4 = Pendiente)
                    null                              // cod_motivo (inicialmente null)
                    );
                
                // Debug: Verificar objeto tutoria creado
                error_log("TutoriaDTO creado: " . print_r([
                    'estudiante' => $tutoria->getCod_estudiante(),
                    'tutor' => $tutoria->getCod_tutor(),
                    'fecha' => $tutoria->getFecha(),
                    'hora_inicio' => $tutoria->getHora_inicio(),
                    'hora_fin' => $tutoria->getHora_fin(),
                    'estado' => $tutoria->getCod_estado()
                ], true));
                
                // Guardar en la base de datos
                $idTutoria = $this->tutoriaDAO->crearTutoria($tutoria);
                
                if (!$idTutoria) {
                    throw new Exception("No se pudo crear la tutoría en la base de datos");
                }
                
                // Debug: Confirmar ID generado
                error_log("Tutoría creada con ID: " . $idTutoria);
                
                // Redirección exitosa
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/showTutoriaConfirmation&id=' . $idTutoria);
                exit;
                
        } catch (Exception $e) {
            // Debug: Mostrar error
            error_log("Error en procesarSolicitudTutoria: " . $e->getMessage());
            
            // Redirección con error
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/requestTutorial&tutor_id=' . ($_POST['tutor_id'] ?? ''));
            exit;
        }
    }
    
    /**
     * Mostrar confirmación de tutoría (mejorado)
     */
    public function mostrarConfirmacionTutoria($tutoriaId) {
        $this->verificarSesionEstudiante();
        
        try {
            if (empty($tutoriaId)) {
                throw new Exception("ID de tutoría no proporcionado");
            }
            
            $tutoria = $this->tutoriaDAO->obtenerTutoriaPorId($tutoriaId);
            
            if (!$tutoria) {
                throw new Exception("Tutoría no encontrada");
            }
            
            // Verificar que la tutoría pertenece al estudiante
            if ($tutoria->getCod_estudiante() != $_SESSION['usuario']->getCodigo()) {
                throw new Exception("No tienes permiso para ver esta tutoría");
            }
            
            // Obtener datos adicionales
            $tutor = $this->tutorDAO->getid($tutoria->getCod_tutor());
            $motivo = $tutoria->getCod_motivo() ? $this->motivoDAO->obtenerMotivoPorCodigo($tutoria->getCod_motivo()) : null;
            
            if (!$tutor) {
                throw new Exception("Información del tutor no disponible");
            }
            
            // Preparar datos para la vista
            $data = [
                'tutoria' => $tutoria,
                'tutor' => $tutor,
                'motivo' => $motivo,
                'BASE_URL' => BASE_URL
            ];
            
            // Cargar la vista de confirmación
            require_once __DIR__ . '/../../view/tutoria/confirmacion_tutoria.php';
            
        } catch (Exception $e) {
            error_log("Error en mostrarConfirmacionTutoria: " . $e->getMessage());
            
            // Redirigir a la búsqueda de tutores con mensaje de error
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/showTutorSearch');
            exit;
        }
    }
    
    /**
     * Lista las tutorías del estudiante
     */
    public function listarTutoriasEstudiante() {
        $this->verificarSesionEstudiante();
        
        $codEstudiante = $_SESSION['usuario']->getCodigo();
        $tutorias = $this->tutoriaDAO->obtenerTutoriasPorEstudiante($codEstudiante);
        
        // Obtener detalles adicionales para cada tutoría
        $tutoriasDetalladas = [];
        foreach ($tutorias as $tutoria) {
            // Usar método getid de TutorDAO que ya existe
            $tutor = $this->tutorDAO->getid($tutoria->getCod_tutor());
            $estado = $this->estadoDAO->obtenerEstadoPorCodigo($tutoria->getCod_estado());
            $motivo = $this->motivoDAO->obtenerMotivoPorCodigo($tutoria->getCod_motivo());
            
            $tutoriasDetalladas[] = [
                'tutoria' => $tutoria,
                'tutor' => $tutor,
                'estado' => $estado,
                'motivo' => $motivo
            ];
        }
        
        require __DIR__ . '/../../view/estudiante/mis_tutorias.php';
    }
    
    /**
     * Cancela una tutoría
     */
    public function cancelarTutoria($idTutoria, $codMotivo) {
        $this->verificarSesionEstudiante();
        
        try {
            $tutoria = $this->tutoriaDAO->obtenerTutoriaPorId($idTutoria);
            if (!$tutoria) {
                throw new Exception("Tutoría no encontrada");
            }
            
            // Actualizar con motivo de cancelación
            $tutoria->setCod_motivo($codMotivo);
            $tutoria->setCod_estado(6); 
            
            $result = $this->tutoriaDAO->actualizarTutoria($tutoria);
            
            if ($result) {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/misTutorias&success=tutoria_cancelada');
                exit;
            }
            
            throw new Exception("Error al cancelar tutoría");
            
        } catch (Exception $e) {
            error_log("Error en cancelarTutoria: " . $e->getMessage());
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/misTutorias&error=cancel_error');
            exit;
        }
    }
    
    /**
     * Valida los datos de la solicitud
     */
    private function validarDatosSolicitud($data) {
        $required = ['tutor_id', 'fecha', 'hora_inicio', 'hora_fin', 'motivo'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                error_log("Campo requerido faltante: $field");
                return false;
            }
        }
        
        if (!$this->validarFecha($data['fecha'])) {
            error_log("Fecha no válida: " . $data['fecha']);
            return false;
        }
        
        if (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $data['hora_inicio']) ||
            !preg_match('/^\d{2}:\d{2}:\d{2}$/', $data['hora_fin'])) {
                error_log("Formato de hora no válido");
                return false;
            }
            
            return true;
    }
    
    /**
     * Valida una fecha (formato YYYY-MM-DD)
     */
    private function validarFecha($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
    
    /**
     * Verifica la sesión del estudiante
     */
    private function verificarSesionEstudiante() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'estudiante') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=unauthorized');
            exit;
        }
    }
    
    public function obtenerSolicitudesPendientes($codTutor) {
        try {
            $stmt = $this->conn->prepare("
            SELECT a.*,
                   e.nombre as nombre_estudiante,
                   e.correo as correo_estudiante
            FROM agendar a
            JOIN estudiante e ON a.cod_estudiante = e.codigo
            WHERE a.cod_tutor = ?
            AND a.cod_estado = 4  -- Estado Pendiente
            ORDER BY a.fecha, a.hora_inicio
        ");
            $stmt->bind_param("i", $codTutor);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $solicitudes = [];
            while ($row = $result->fetch_assoc()) {
                $solicitudes[] = $row;
            }
            
            return $solicitudes;
            
        } catch (Exception $e) {
            error_log("Error en obtenerSolicitudesPendientes: " . $e->getMessage());
            return [];
        }
    }
    
    public function mostrarSolicitudesTutor() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'tutor') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login');
            exit;
        }
        
        try {
            $codTutor = $_SESSION['usuario']->getCodigo();
            $solicitudes = $this->tutoriaDAO->obtenerSolicitudesPendientes($codTutor);
            $motivos = $this->motivoDAO->listarMotivos();
            
            // Pasar los datos a la vista correctamente
            $data = [
                'solicitudes' => $solicitudes,
                'motivos' => $motivos,
                'BASE_URL' => BASE_URL
            ];
            
            // Extraer variables para la vista
            extract($data);
            
            require_once __DIR__ . '/../../view/tutor/solicitudes_tutorias.php';
            
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Error al cargar solicitudes: " . $e->getMessage();
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/dashboardTutor');
            exit;
        }
    }

public function procesarAprobacion() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    try {
        // 1. Validar y obtener ID
        $idTutoria = $_POST['id_tutoria'] ?? null;
        if (empty($idTutoria)) {
            throw new Exception("ID de tutoría no proporcionado");
        }
        
        // 2. Aprobar en BD
        $this->tutoriaDAO->actualizarEstado($idTutoria, 5);
        
        $_SESSION['success_message'] = "Tutoría aprobada correctamente";
        
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }
    
    header('Location: ' . BASE_URL . 'index.php?url=RouteController/showTutorRequests');
    exit;
}

public function procesarRechazo() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    try {
        // Validar datos
        $idTutoria = $_POST['id_tutoria'] ?? null;
        $motivo = $_POST['motivo'] ?? null;
        
        if (empty($idTutoria) || empty($motivo)) {
            throw new Exception("Datos incompletos para rechazo");
        }
        
        // Rechazar en BD
        $this->tutoriaDAO->actualizarEstadoYMotivo($idTutoria, 6, $motivo);
        
        $_SESSION['success_message'] = "Tutoría rechazada correctamente";
        
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }
    
    header('Location: ' . BASE_URL . 'index.php?url=RouteController/showTutorRequests');
    exit;
}
    
    private function verificarSesionTutor() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'tutor') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=unauthorized');
            exit;
        }
    }
    
    
}
?>