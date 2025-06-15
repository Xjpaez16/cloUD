<?php
  class StudentController {
    private $studenteDAO;
    private $studentDTO;
    private $validation;
    private $carrerDAO;
    

    public function __construct()
    {
       
        require_once(__DIR__ . '/models/DAO/EstudianteDAO.php');
        require_once(__DIR__ . '/models/DTO/EstudianteDTO.php');
        require_once(__DIR__ . '/models/DAO/CarreraDAO.php');
        require_once(__DIR__ . '/utils/validation.php');

        $this->studentDAO =  new EstudianteDAO();
        $this->studentDTO =  new EstudianteDTO();
        $this->validation = new validation();
        $this->carrerDAO = new CarreraDAO();
    }

    public function viewcarrers()
    {
        if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }

        $estudiante = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
        if (!$estudiante) {
        error_log('No hay sesión activa de estudiante.');
        // Puedes redirigir o mostrar un error amigable aquí si lo deseas
        header('Location: ' . BASE_URL . 'index.php?url=RouteController/login');
        exit;
        }

        $carreras = $this->carrerDAO->listcarrers();
        require_once(__DIR__ . '/../../view/editStudent.php');
    }

    public function updateProfile()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $student = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
        if (!$student) {
            error_log('No hay sesión activa de estudiante.');
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login');
            exit;
        }
        
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $carrera = $_POST['carrer'];
        $correo = "e" . $correo; // Asegurarse de que el correo tenga el prefijo 'e' para estudiante
        error_log("Carrera seleccionada: " . $carrera); 
        // Validar los datos
       
        if (!$this->validation->validateEmail($correo)) {
            error_log('Correo inválido: ' . $correo);
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/editStudent&error=2');
            exit;
        }

        // Actualizar el tutor
        $student->setNombre($nombre);
        $student->setCorreo($correo);
        $student->setCod_carrera($carrera);

        if ($this->studentDAO->update($student->getCodigo(),$student)) {
            $_SESSION['usuario'] = $student; // Actualizar la sesión
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/student');
            exit;
        } else {
            error_log('Error al actualizar el perfil del estudiante.');
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/editStudent&error=3');
            exit;
        }
    }
    

  }

?>