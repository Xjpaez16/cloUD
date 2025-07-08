<?php
class MotivoAdminController {
    private $motivoDAO;

    public function __construct() {
        require_once(__DIR__ . '/models/DTO/MotivoDTO.php');
        require_once(__DIR__ . '/models/DAO/MotivoDAO.php');
        $this->motivoDAO = new MotivoDAO();
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }

        $motivos = $this->motivoDAO->listar_Motivos();
        $data = ['motivos' => $motivos];
        require __DIR__ . '/../../view/motivo_crud.php';
    }

    public function create() {
        $codigo = $_POST['codigo'];
        $tipo = $_POST['tipo_motivo'];

        if (!$this->motivoDAO->crearMotivo($codigo, $tipo)) {
            header('Location: ' . BASE_URL . 'index.php?url=MotivoAdminController/index&error=duplicado');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=MotivoAdminController/index&success=1');
        exit;
    }

    public function update() {
        $codigo_actual = $_POST['codigo_actual'];
        $codigo = $_POST['codigo'];
        $tipo = $_POST['tipo_motivo'];

        if (!$this->motivoDAO->actualizarMotivo($codigo_actual, $codigo, $tipo)) {
            header('Location: ' . BASE_URL . 'index.php?url=MotivoAdminController/index&error=duplicado');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=MotivoAdminController/index&success=2');
        exit;
    }
}
?>
