<?php
class MateriaAdminController {
    private $materiaDAO;

    public function __construct() {
        require_once(__DIR__ . '/models/DAO/MateriaDAO.php');
        $this->materiaDAO = new MateriaDAO();
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }

        $materias = $this->materiaDAO->listmaterias();
        $data = ['materias' => $materias];
        require __DIR__ . '/../../view/materia_crud.php';
    }

    public function create() {
        $id = $_POST['id'];
        $nombre = $_POST['nombre_materia'];

        if (!$this->materiaDAO->crearMateria($id, $nombre)) {
            header('Location: ' . BASE_URL . 'index.php?url=MateriaAdminController/index&error=duplicado');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=MateriaAdminController/index&success=1');
        exit;
    }

    public function update() {
        $id_actual = $_POST['id_actual'];
        $id_nuevo = $_POST['id'];
        $nombre = $_POST['nombre_materia'];

        if (!$this->materiaDAO->actualizarMateria($id_actual, $id_nuevo, $nombre)) {
            header('Location: ' . BASE_URL . 'index.php?url=MateriaAdminController/index&error=duplicado');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=MateriaAdminController/index&success=2');
        exit;
    }
}
