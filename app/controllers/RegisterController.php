<?php
class RegisterController
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
        require_once(__DIR__ . '/models/DAO/CarreraDAO.php');
        require_once(__DIR__ . '/models/DAO/AreaDAO.php');

        $this->estudianteDAO = new EstudianteDAO();
        $this->tutorDAO = new TutorDAO();
        $this->estudianteDTO = new EstudianteDTO();
        $this->tutorDTO = new TutorDTO();
        $this->validation = new validation();
        $this->carrerDAO = new CarreraDAO();
        $this->areaDAO = new AreaDAO();
        $this->areaDTO = new AreaDTO();
    }
    public function viewcarrers()
    {
        $carrers = $this->carrerDAO->listcarrers();
        require_once(__DIR__ . '/../../view/studentregister.php');
    }

    public function viewareas()
    {
        $areas = $this->areaDAO->listarea();
        require_once(__DIR__ . '/../../view/tutorregister.php');
    }

    //selecionar el rol del usuario, si es estudiante o tutor
    public  function role()
    {
        $role = isset($_GET['role']) ? $_GET['role'] : null;
        //verifica si el rol es estudiante o tutor

        if ($role === "estudiante") {

            $role = "estudiante";
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/studentregister');
        } elseif ($role === "tutor") {

            $role = "tutor";
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/tutorregister');
        }

        return $role;
    }

    //registro de usuario
    public function registerstudent()
    {

        $carrer = $_POST['carrer'];
        error_log("Carrera seleccionada: " . $carrer);
        $code = $_POST['code'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $question1 = $_POST['response1'];
        $question2 = $_POST['response2'];
        $password = $_POST['password'];


        if ($this->validation->validateEmail($email) && $this->validation->validatepassword($password)) {

            if ($this->estudianteDAO->comprobarCorreo($email) === false) {
                $this->estudianteDTO->setCod_carrera($carrer);
                $this->estudianteDTO->setCodigo($code);
                $this->estudianteDTO->setNombre($name);
                $this->estudianteDTO->setCorreo($email);
                $this->estudianteDTO->setRespuesta_preg($question1 . "" . $question2);
                $this->estudianteDTO->setContrasena(password_hash($password, PASSWORD_DEFAULT));
                $this->estudianteDTO->setCod_estado(2); // 2 = activo
                $response = $this->estudianteDAO->create($this->estudianteDTO);
                if ($response) {
                    echo "Estudiante registrado exitosamente";
                } else {
                    echo "Error al registrar el estudiante";
                }
            } else {
                echo "El estudiante ya existe";
            }
        } else {
            echo "Correo o contraseña invalida";
        }
    }

    public function registertutor()
    {

        $code = $_POST['code'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $question1 = $_POST['response1'];
        $question2 = $_POST['response2'];
        $password = $_POST['password'];
        $areas = $_POST['area'];
        if (!empty($areas)) {
            if ($this->validation->validateEmail($email) && $this->validation->validatepassword($password)) {

                if ($this->tutorDAO->comprobarCorreo($email) === false) {
                    $this->tutorDTO->setCodigo($code);
                    $this->tutorDTO->setNombre($name);
                    $this->tutorDTO->setCorreo($email);
                    $this->tutorDTO->setRespuesta_preg($question1 . "" . $question2);
                    $this->tutorDTO->setContrasena(password_hash($password, PASSWORD_DEFAULT));
                    $this->tutorDTO->setCod_estado(2); // 2 = activo
                    $this->tutorDTO->setCalificacion_general(5.0);
                    $this->tutorDTO->setAreas($areas);
                    $response = $this->tutorDAO->create($this->tutorDTO);
                    $this->tutorDAO->insertarAreasDeTutor($this->tutorDTO);
                    if ($response) {
                        echo "Tutor registrado exitosamente";
                    } else {
                        echo "Error al registrar el tutor";
                    }
                } else {
                    echo "El tutor ya existe";
                }
            } else {
                echo "Correo o contraseña invalida";
            }
        } else {
            echo "Debe seleccionar al menos un area de conocimiento";
        }
    }
}
