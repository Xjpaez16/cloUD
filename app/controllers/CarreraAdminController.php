<?php
class CarreraAdminController {
    private $carreraDAO;

    public function __construct() {
        require_once(__DIR__ . '/models/DAO/CarreraDAO.php');
        $this->carreraDAO = new CarreraDAO();
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }

        $carreras = $this->carreraDAO->listcarrers();
        $data = ['carreras' => $carreras];
        require __DIR__ . '/../../view/carrera_crud.php';
    }

    public function create() {
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre_carrera'];

        if (!$this->carreraDAO->crearCarrera($codigo, $nombre)) {
            header('Location: ' . BASE_URL . 'index.php?url=CarreraAdminController/index&error=duplicado');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=CarreraAdminController/index&success=1');
        exit;
    }

    public function update() {
        $codigo_actual = $_POST['codigo_actual'];
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre_carrera'];

        if (!$this->carreraDAO->actualizarCarrera($codigo_actual, $codigo, $nombre)) {
            header('Location: ' . BASE_URL . 'index.php?url=CarreraAdminController/index&error=duplicado');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=CarreraAdminController/index&success=2');
        exit;
    }
}
?>