<?php
class TutorAdminController {
    private $tutorDAO;
    private $validation;

    public function __construct() {
        require_once(__DIR__ . '/models/DAO/TutorDAO.php');
        require_once(__DIR__ . '/models/DTO/TutorDTO.php');
        require_once(__DIR__ . '/utils/validation.php');
        $this->tutorDAO = new TutorDAO();
        $this->validation = new validation();
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }
        $tutores = $this->tutorDAO->todos();
        $data = ['tutores' => $tutores];
        require __DIR__ . '/../../view/tutor_crud.php';
    }
    public function create() {
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];
        $calificacion_general = isset($_POST['calificacion_general']) ? $_POST['calificacion_general'] : 0;
        $respuesta_preg = $_POST['respuesta_preg'];
        $cod_estado = 2;

        if (!$this->validation->validateEmail($correo)) {
            header('Location: ' . BASE_URL . 'index.php?url=TutorAdminController/index&error=emailinvalido');
            exit;
        }

        if (!$this->validation->validatepassword($contrasena)) {
            header('Location: ' . BASE_URL . 'index.php?url=TutorAdminController/index&error=claveinvalida');
            exit;
        }

        // Verificar si ya existe un tutor con el mismo ID, correo o nombre
        $todos = $this->tutorDAO->todos();
        foreach ($todos as $tutor) {
            if (
                $tutor->getCodigo() == $codigo ||
                strtolower($tutor->getCorreo()) == strtolower($correo) ||
                strtolower($tutor->getNombre()) == strtolower($nombre)
            ) {
                header('Location: ' . BASE_URL . 'index.php?url=TutorAdminController/index&error=idocorreooNombre');
                exit;
            }
        }

        $tutor = new TutorDTO($codigo, $nombre, $correo, $contrasena, $calificacion_general, $respuesta_preg, $cod_estado);

        if (!$this->tutorDAO->create($tutor)) {
            header('Location: ' . BASE_URL . 'index.php?url=TutorAdminController/index&error=idduplicado');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=TutorAdminController/index&success=1');
        exit;
    }


    public function update() {
        $codigo_actual = $_POST['codigo_actual'];
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $calificacion_general = isset($_POST['calificacion_general']) ? $_POST['calificacion_general'] : null;
        $respuesta_preg = $_POST['respuesta_preg'];

        if (!$this->validation->validateEmail($correo)) {
            header('Location: ' . BASE_URL . 'index.php?url=TutorAdminController/index&error=emailinvalido');
            exit;
        }

        $tutor = $this->tutorDAO->getid($codigo_actual);
        if (!$tutor) {
            header('Location: ' . BASE_URL . 'index.php?url=TutorAdminController/index&error=notfound');
            exit;
        }

        // Verificar si otro tutor ya tiene ese nombre o correo
        $todos = $this->tutorDAO->todos();
        foreach ($todos as $otro) {
            if ($otro->getCodigo() != $codigo_actual) {
                if (
                    strtolower($otro->getCorreo()) == strtolower($correo) ||
                    strtolower($otro->getNombre()) == strtolower($nombre)
                ) {
                    header('Location: ' . BASE_URL . 'index.php?url=TutorAdminController/index&error=correooNombreDuplicado');
                    exit;
                }
            }
        }

        // Verificar si está cambiando el ID a uno ya usado por otro
        if ($codigo !== $codigo_actual && $this->tutorDAO->getid($codigo)) {
            header('Location: ' . BASE_URL . 'index.php?url=TutorAdminController/index&error=idduplicado');
            exit;
        }

        $tutor->setCodigo($codigo);
        $tutor->setNombre($nombre);
        $tutor->setCorreo($correo);
        if ($calificacion_general !== null) {
            $tutor->setCalificacion_general($calificacion_general);
        }
        $tutor->setRespuesta_preg($respuesta_preg);

        if ($this->tutorDAO->update($codigo_actual, $tutor)) {
            header('Location: ' . BASE_URL . 'index.php?url=TutorAdminController/index&success=2');
            exit;
        } else {
            header('Location: ' . BASE_URL . 'index.php?url=TutorAdminController/index&error=updatefail');
            exit;
        }
    }



    public function delete() {
        $codigo = $_GET['codigo'];
        $this->tutorDAO->desactivarTutor($codigo);
    }

    public function activar() {
        $codigo = $_GET['codigo'];
        $this->tutorDAO->activarTutor($codigo);
        echo json_encode(['success' => true]);
    }
}
?>