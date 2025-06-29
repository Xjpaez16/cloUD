<?php
class AdminController {
    private $adminDAO;

    public function __construct() {
        require_once(__DIR__ . '/../controllers/models/DAO/AdminDAO.php');
        $this->adminDAO = new AdminDAO();
    }
    public function obtenerAdmin() {
        return $this->adminDAO->obtenerAdminPorId(1);
    }
    public function index() {
        session_start();
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }
        $admins = $this->adminDAO->obtenerTodos();
        $data = ['admins' => $admins];
        require __DIR__ . '/../../view/admin_crud.php';
    }

    public function create() {
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $clave = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
        $respuesta_preg = '';
        $this->adminDAO->crearAdmin($nombre, $correo, $clave, $respuesta_preg);
        header('Location: ' . BASE_URL . 'index.php?url=AdminController/index');
        exit;
    }

    public function update() {
        $id = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $this->adminDAO->actualizarAdmin($id, $nombre, $correo);
        header('Location: ' . BASE_URL . 'index.php?url=AdminController/index');
        exit;
    }

    public function delete() {
        $id = $_GET['codigo'];
        $this->adminDAO->desactivarAdmin($id);
        header('Location: ' . BASE_URL . 'index.php?url=AdminController/index');
        exit;
    }
}
?>
