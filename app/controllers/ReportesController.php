<?php
class ReportesController
{
    private $tutoriaDAO;
    private $tutorDAO;
    private $archivoDAO;

    public function __construct(){
        
        
        require_once(__DIR__ . '/models/DAO/TutorDAO.php');
        require_once(__DIR__ . '/models/DAO/TutoriaDAO.php');
        require_once(__DIR__ . '/models/DAO/ArchivoDAO.php');

        $this->archivoDAO = new ArchivoDAO;
        $this->tutorDAO = new TutorDAO;
        $this->tutoriaDAO = new TutoriaDAO;
    }
    public function index()
    {
        require_once __DIR__ . '/../../view/reportes.php';
    }

    public function generar()
    {
        $action = $_GET['action'] ?? '';
        $desde = $_GET['desde'] ?? null;
        $hasta = $_GET['hasta'] ?? null;

        
        $data = [];

        switch ($action) {
            case 'reporte1':
                if ($desde && $hasta) {
                    $data = $this->tutoriaDAO->obtenerTutorMasAgendado($desde, $hasta);
                }
                break;

            case 'reporte2':
                if ($desde && $hasta) {
                    $data = $this->tutoriaDAO->obtenerEstudianteMasActivo($desde, $hasta);
                }
                break;

            case 'reporte3':
                $data = $this->tutorDAO->top3TutoresPorCalificacion();
                break;

            case 'reporte4':
                $data = $this->archivoDAO->estudianteConMasArchivos();
                break;

            default:
                echo json_encode(['error' => 'Acción inválida']);
                return;
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
