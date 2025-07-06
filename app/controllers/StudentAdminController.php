<?php
class StudentAdminController {
    private $studentDAO;
    private $validation;
    private $carrerDAO;

    public function __construct() {
        require_once(__DIR__ . '/models/DAO/EstudianteDAO.php');
        require_once(__DIR__ . '/models/DTO/EstudianteDTO.php');
        require_once(__DIR__ . '/models/DAO/CarreraDAO.php');
        require_once(__DIR__ . '/utils/validation.php');
        $this->studentDAO = new EstudianteDAO();
        $this->validation = new validation();
        $this->carrerDAO = new CarreraDAO();
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }
        $estudiantes = $this->studentDAO->getAll();
        $carreras = $this->carrerDAO->listcarrers();
        $data = ['estudiantes' => $estudiantes, 'carreras' => $carreras];
        require __DIR__ . '/../../view/student_crud.php';
    }

    public function create() {
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];
        $respuesta_preg = $_POST['respuesta_preg'];
        $cod_carrera = $_POST['cod_carrera'];
        $cod_estado = 2;

        if (!$this->validation->validateEmail($correo)) {
            header('Location: ' . BASE_URL . 'index.php?url=StudentAdminController/index&error=emailinvalido');
            exit;
        }
        if (!$this->validation->validatepassword($contrasena)) {
            header('Location: ' . BASE_URL . 'index.php?url=StudentAdminController/index&error=claveinvalida');
            exit;
        }

        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $estudiante = new EstudianteDTO($codigo, $nombre, $correo, $contrasena_hash, $respuesta_preg, $cod_carrera, $cod_estado);

        if (!$this->studentDAO->create($estudiante)) {
            header('Location: ' . BASE_URL . 'index.php?url=StudentAdminController/index&error=idduplicado');
            exit;
        }
        header('Location: ' . BASE_URL . 'index.php?url=StudentAdminController/index&success=1');
        exit;
    }

    public function update() {
        $codigo_actual = $_POST['codigo_actual'];
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $respuesta_preg = $_POST['respuesta_preg'];
        $cod_carrera = $_POST['cod_carrera'];

        if (!$this->validation->validateEmail($correo)) {
            header('Location: ' . BASE_URL . 'index.php?url=StudentAdminController/index&error=emailinvalido');
            exit;
        }

        $estudiante = $this->studentDAO->getid($codigo_actual);
        if (!$estudiante) {
            header('Location: ' . BASE_URL . 'index.php?url=StudentAdminController/index&error=notfound');
            exit;
        }
        $estudiante->setCodigo($codigo);
        $estudiante->setNombre($nombre);
        $estudiante->setCorreo($correo);
        $estudiante->setRespuesta_preg($respuesta_preg);
        $estudiante->setCod_carrera($cod_carrera);

        if ($this->studentDAO->update($codigo_actual, $estudiante)) {
            header('Location: ' . BASE_URL . 'index.php?url=StudentAdminController/index&success=2');
            exit;
        } else {
            header('Location: ' . BASE_URL . 'index.php?url=StudentAdminController/index&error=updatefail');
            exit;
        }
    }

    public function delete() {
        $codigo = $_GET['codigo'];
        $this->studentDAO->desactivarEstudiante($codigo);
    }

    public function activar() {
        $codigo = $_GET['codigo'];
        $this->studentDAO->activarEstudiante($codigo);
        echo json_encode(['success' => true]);
    }
}
?>