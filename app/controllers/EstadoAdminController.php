<?php
class EstadoAdminController {
    private $estadoDAO;

    public function __construct() {
        require_once(__DIR__ . '/models/DAO/EstadoDAO.php');
        $this->estadoDAO = new EstadoDAO();
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }

        $estados = $this->estadoDAO->getAll();
        $data = ['estados' => $estados];
        require __DIR__ . '/../../view/estado_crud.php';
    }

    public function create() {
        $codigo = $_POST['codigo'];
        $tipo = $_POST['tipo_estado'];

        if (!$this->estadoDAO->crearEstado($codigo, $tipo)) {
            header('Location: ' . BASE_URL . 'index.php?url=EstadoAdminController/index&error=duplicado');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=EstadoAdminController/index&success=1');
        exit;
    }

    public function update() {
        $codigo_actual = $_POST['codigo_actual'];
        $codigo = $_POST['codigo'];
        $tipo = $_POST['tipo_estado'];

        if (!$this->estadoDAO->updateEstado($codigo_actual, $codigo, $tipo)) {
            header('Location: ' . BASE_URL . 'index.php?url=EstadoAdminController/index&error=duplicado');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=EstadoAdminController/index&success=2');
        exit;
    }
}
?>
