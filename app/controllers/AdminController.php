<?php

require_once(__DIR__ . '/models/DAO/AdministradorDAO.php');
require_once(__DIR__ . '/models/DTO/AdministradorDTO.php');
require_once(__DIR__ . '/utils/validation.php');
require_once(__DIR__ . '/../../core/Controller.php');

class AdminController extends Controller
{
    private $administradorDAO;
    private $validation;

    public function __construct()
    {
        $this->administradorDAO = new AdministradorDAO();
        $this->validation = new Validation();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit();
        }
    }

    public function manageAdmins()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit();
        }

        $administradores = $this->administradorDAO->getAllAdministradores();
        $this->view('admin_crud', ['administradores' => $administradores]);
    }

    public function addAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo = $_POST['codigo'];
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $password = $_POST['password'];
            $respuesta_preg1 = $_POST['respuesta_preg1'];
            $respuesta_preg2 = $_POST['respuesta_preg2'];
            $respuesta_preg = $respuesta_preg1 . $respuesta_preg2;

            if (!$this->validation->validateEmail($correo)) {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins&error=email_invalido');
                exit;
            }
            if (!$this->validation->validatePassword($password)) {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins&error=password_invalida');
                exit;
            }
            if ($this->administradorDAO->comprobarCorreo($correo)) {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins&error=correo_existente');
                exit;
            }

            $administradorDTO = new AdministradorDTO(
                $codigo,
                $nombre,
                $correo,
                password_hash($password, PASSWORD_DEFAULT), // Hashear la contraseña
                $respuesta_preg,
                $codigo
            );

            if ($this->administradorDAO->create($administradorDTO)) {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins&success=admin_added');
                exit;
            } else {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins&error=add_failed');
                exit;
            }
        } else {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins');
            exit;
        }
    }

    public function editAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $respuesta_preg1 = $_POST['respuesta_preg1'];
            $respuesta_preg2 = $_POST['respuesta_preg2'];
            $respuesta_preg = $respuesta_preg1 . $respuesta_preg2;
            $password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : null;

            $administradorExistente = $this->administradorDAO->getAdministradorById($id);
            if (!$administradorExistente) {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins&error=admin_not_found');
                exit;
            }

            if ($correo !== $administradorExistente->getCorreo() && $this->administradorDAO->comprobarCorreo($correo)) {
                 header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins&error=correo_existente_edit');
                 exit;
            }
            if (!$this->validation->validateEmail($correo)) {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins&error=email_invalido_edit');
                exit;
            }


            $administradorDTO = new AdministradorDTO(
                $id,
                $nombre,
                $correo,
                $administradorExistente->getContrasena(),
                $respuesta_preg,
                $id
            );

            if ($password) {
                if (!$this->validation->validatePassword($password)) {
                     header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins&error=password_invalida_edit');
                     exit;
                }
                $administradorDTO->setContrasena(password_hash($password, PASSWORD_DEFAULT));
            }


            if ($this->administradorDAO->update($administradorDTO)) {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins&success=admin_updated');
                exit;
            } else {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins&error=update_failed');
                exit;
            }
        } else {
             header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins');
             exit;
        }
    }

    public function deleteAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            if ($_SESSION['usuario']->getCodigo() === $id) {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins&error=cannot_delete_self');
                exit;
            }

            if ($this->administradorDAO->delete($id)) {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins&success=admin_deleted');
                exit;
            } else {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins&error=delete_failed');
                exit;
            }
        } else {
            // Si no es POST, redirigir
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/manageAdmins');
            exit;
        }
    }
}