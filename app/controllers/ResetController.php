<?php
class ResetController
{
    //esto lo hice para que me autocomplete el codigo el visual studio code
    /** @var EstudianteDAO */
    private $estudianteDAO;

    /** @var TutorDAO */
    private $tutorDAO;

    /** @var EstudianteDTO */
    private $estudianteDTO;

    /** @var TutorDTO */
    private $tutorDTO;

    /** @var CarreraDAO */
    private $carrerDAO;

    /** @var AreaDAO */
    private $areaDAO;

    /** @var AreaDTO */
    private $areaDTO;

    /** @var validation */
    private $validation;

    public function __construct()
    {
        require_once(__DIR__ . '/models/DAO/EstudianteDAO.php');
        require_once(__DIR__ . '/models/DAO/TutorDAO.php');
        require_once(__DIR__ . '/models/DTO/EstudianteDTO.php');
        require_once(__DIR__ . '/models/DTO/TutorDTO.php');
        require_once(__DIR__ . '/utils/validation.php');


        $this->estudianteDAO = new EstudianteDAO();
        $this->tutorDAO = new TutorDAO();
        $this->estudianteDTO = new EstudianteDTO();
        $this->tutorDTO = new TutorDTO();
        $this->validation = new validation();
    }

    public function resetPassword()
    {
        $email = $_POST['email'];
        if ($this->validation->validateEmail($email)) {
            $rol = $_POST['rol'];
            $response1 = $_POST['response1'];
            $response2 = $_POST['response2'];
            $password = $_POST['password'];
            
            if ($this->validation->validatepassword($password)) {
                $responseconcatenated = $response1 . $response2;
                $password = password_hash($password, PASSWORD_DEFAULT);
                if ($rol == "estudiante") {
                    $rta = $this->estudianteDAO->comprobarRtaSeguridad($email, $responseconcatenated);
                    if ($rta) {
                        $error = $this->estudianteDAO->cambiarContrasena($email, $password);
                        header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&success=3');
                        exit;
                    } else {
                        header('Location: ' . BASE_URL . 'index.php?url=RouteController/resetPassword&error=1');
                    }
                } else if ($rol == "tutor") {
                    $rta = $this->tutorDAO->comprobarRtaSeguridad($email, $responseconcatenated);
                    if ($rta) {
                        $error = $this->tutorDAO->cambiarContrasena($email, $password);
                        header('Location: ' . BASE_URL . 'index.php?url=RouteController/login');
                        exit;
                    } else {
                       header('Location: ' . BASE_URL . 'index.php?url=RouteController/resetPassword&error=1');
                    }
                }
            } else {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/resetPassword&error=2');
            }
        } else {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/resetPassword&error=3');
        }
    }

    public function changePassword()
    {
        session_start();
        $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
        $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
        $response1 = $_POST['response1'];
        $response2 = $_POST['response2'];
        $password = $_POST['password'];
        if ($rol == "estudiante") {
            $email = $usuario->getCorreo();
            if ($this->validation->validatepassword($password)) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $responseconcatenated = $response1 . $response2;
                $rta = $this->estudianteDAO->comprobarRtaSeguridad($email, $responseconcatenated);
                if ($rta) {
                    $error = $this->estudianteDAO->cambiarContrasena($email, $password);
                    
                    $this->logout();
                } else {
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/changePassword&error=1');
                }
            } else {
                 header('Location: ' . BASE_URL . 'index.php?url=RouteController/changePassword&error=2');
            }
        } else if ($rol == "tutor") {
            $email = $usuario->getCorreo();
            if ($this->validation->validatepassword($password)) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $responseconcatenated = $response1 . $response2;
                $rta = $this->tutorDAO->comprobarRtaSeguridad($email, $responseconcatenated);
                if ($rta) {
                    $error = $this->tutorDAO->cambiarContrasena($email, $password);
                    
                    $this->logout(); // Cerrar sesión después de cambiar la contraseña
                } else {
                     header('Location: ' . BASE_URL . 'index.php?url=RouteController/changePassword&error=1');
                }
            } else {
                 header('Location: ' . BASE_URL . 'index.php?url=RouteController/changePassword&error=2');
            }
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&success=3');
        exit;
    }
}
