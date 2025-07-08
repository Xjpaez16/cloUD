<?php
class AreaAdminController {
    private $areaDAO;

    public function __construct() {
        require_once(__DIR__ . '/models/DAO/AreaDAO.php');
        $this->areaDAO = new AreaDAO();
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }

        $areas = $this->areaDAO->listarea();
        $data = ['areas' => $areas];
        require __DIR__ . '/../../view/area_crud.php';
    }

    public function create() {
        $codigo = $_POST['codigo'] ?? '';
        $nombre = trim($_POST['nombre']);

         if ($this->areaDAO->existeCodigo($codigo)) {
            header('Location: ' . BASE_URL . 'index.php?url=AreaAdminController/index&error=idduplicado');
            exit;
        }

        if ($this->areaDAO->existeNombre(strtoupper($nombre))) {
            header('Location: ' . BASE_URL . 'index.php?url=AreaAdminController/index&error=nombreduplicado');
            exit;
        }

        if (!$this->areaDAO->crearArea($codigo,$nombre)) {
            header('Location: ' . BASE_URL . 'index.php?url=AreaAdminController/index&error=1');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=AreaAdminController/index&success=1');
        exit;
    }

    public function update() {
        $codigo = $_POST['codigo'] ?? '';
        $codigo_actual = $_POST['codigo_actual'];
        $nombre = $_POST['nombre'] ?? '';

        if ($codigo_actual != $codigo && $this->areaDAO->existeCodigo($codigo)) {
            header('Location: ' . BASE_URL . 'index.php?url=AreaAdminController/index&error=idyausado');
            exit;
        }

        if ($this->areaDAO->existeNombreEnOtro(strtoupper($nombre), $codigo_actual)) {
            header('Location: ' . BASE_URL . 'index.php?url=AreaAdminController/index&error=nombreyausado');
            exit;
        }

        if (!$this->areaDAO->actualizarArea($codigo_actual,$codigo, $nombre)) {
            header('Location: ' . BASE_URL . 'index.php?url=AreaAdminController/index&error=duplicado');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=AreaAdminController/index&success=2');
        exit;
    }
}
