<?php
class AdminController {
    private $adminDAO;
    public function __construct() {
        require_once(__DIR__ . '/models/DAO/AdminDAO.php');
        require_once(__DIR__ . '/utils/validation.php');
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
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $clave = $_POST['contrasena'];
        $respuesta_preg = $_POST['respuesta_preg'];

        $validador = new validation();

        if (!$validador->validateEmail($correo)) {
            header('Location: ' . BASE_URL . 'index.php?url=AdminController/index&error=emailinvalido');
            exit;
        }

        if (!$validador->validatepassword($clave)) {
            header('Location: ' . BASE_URL . 'index.php?url=AdminController/index&error=claveinvalida');
            exit;
        }

        //$clave_hash = password_hash($clave, PASSWORD_DEFAULT);

        if (!$this->adminDAO->crearAdmin($id, $nombre, $correo, $clave, $respuesta_preg)) {
            header('Location: ' . BASE_URL . 'index.php?url=AdminController/index&error=idduplicado');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=AdminController/index&success=1');
        exit;
    }


    public function update() {
        $codigo_actual = $_POST['codigo_actual'];
        $nuevo_id = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $respuesta = $_POST['respuesta_preg'];

        $resultado = $this->adminDAO->actualizarAdminConNuevoID($codigo_actual, $nuevo_id, $nombre, $correo, $respuesta);

        $validador = new validation();

        if (!$validador->validateEmail($correo)) {
            header('Location: ' . BASE_URL . 'index.php?url=AdminController/index&error=emailinvalido');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=AdminController/index&success=2');
        exit;
    }

    public function delete() {
        $id = $_GET['codigo'];
        $this->adminDAO->desactivarAdmin($id);
        
    }

    public function activar() {
        $id = $_GET['codigo'];
        $this->adminDAO->activarAdmin($id);
        echo json_encode(['success' => true]);
    }

    

}
?>
