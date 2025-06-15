<?php
  class TutorController {
    private $tutorDAO;
    private $tutorDTO;
    private $validation;
    private $areaDAO;
    private $areaDTO;
    

    public function __construct()
    {
       
        require_once(__DIR__ . '/models/DAO/TutorDAO.php');
        require_once(__DIR__ . '/models/DTO/TutorDTO.php');
        require_once(__DIR__ . '/utils/validation.php');
        require_once(__DIR__ . '/models/DAO/AreaDAO.php');

        
        $this->tutorDAO =  new TutorDAO();
        $this->tutorDTO =  new TutorDTO();
        $this->validation = new validation();
        $this->areaDAO = new AreaDAO();
        $this->areaDTO = new AreaDTO();
        
    }
    
    public function viewAreasChecked()
    {   
        if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }

        $tutor = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
        if (!$tutor) {
        error_log('No hay sesión activa de tutor.');
        // Puedes redirigir o mostrar un error amigable aquí si lo deseas
        header('Location: ' . BASE_URL . 'index.php?url=RouteController/login');
        exit;
        }
        $areas = $this->areaDAO->listarea();
        $checkedAreas = $this->tutorDAO->getAreasByTutor($tutor->getCodigo());
        error_log('Codigo del tutor: ' . $tutor->getCodigo());
        error_log('Areas checked: ' . print_r($checkedAreas, true));
        require_once(__DIR__ . '/../../view/editTutor.php');
    }

    public function updateProfile()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $tutor = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
        if (!$tutor) {
            error_log('No hay sesión activa de tutor.');
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login');
            exit;
        }

        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $areas = isset($_POST['area']) ? $_POST['area'] : [];

        // Validar los datos
       
        if (!$this->validation->validateEmail($correo)) {
            error_log('Correo inválido: ' . $correo);
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/editTutor&error=2');
            exit;
        }

        // Actualizar el tutor
        $tutor->setNombre($nombre);
        $tutor->setCorreo("t".$correo);

        if ($this->tutorDAO->update($tutor->getCodigo(),$tutor)) {
            // Actualizar las áreas del tutor
            $this->tutorDAO->updateAreasByTutor($tutor->getCodigo(), $areas);
            $_SESSION['usuario'] = $tutor; // Actualizar la sesión
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/tutor');
            exit;
        } else {
            error_log('Error al actualizar el perfil del tutor.');
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/editTutor&error=3');
            exit;
        }
    }
    

  }





?>