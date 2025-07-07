<?php
class Profesorcontroller
{
    private $profesorDAO;
    private $areaDAO;
    private $MateriaDAO;

    public function __construct()
    {
        require_once(__DIR__ . '/models/DAO/ProfesorDAO.php');
        require_once(__DIR__ . '/models/DAO/AreaDAO.php');
        require_once(__DIR__ . '/models/DAO/MateriaDAO.php');
        $this->profesorDAO = new ProfesorDAO();
        $this->areaDAO = new AreaDAO();
        $this->MateriaDAO = new MateriaDAO();
    }

    public function index()
    {
        session_start();
        if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
            exit;
        }
        $areas = $this->areaDAO->listarea();
        $materias = $this->MateriaDAO->listmaterias();
        $profesores = $this->profesorDAO->listteachers();
        require __DIR__ . '/../../view/Profesores_crud.php';
    }

    public function create()
    {
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];

        if (!$this->profesorDAO->crearProfesor($codigo, $nombre)) {
            header('Location: ' . BASE_URL . 'index.php?url=Profesorcontroller/index&error=duplicado');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=Profesorcontroller/index&success=1');
        exit;
    }

    public function update()
    {

        $codigo_actual = $_POST['codigo'];
        $nombre = $_POST['nombre'];

        if (!$this->profesorDAO->actualizarProfesor($codigo_actual, $nombre)) {
            header('Location: ' . BASE_URL . 'index.php?url=Profesorcontroller/index&error=duplicado');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=Profesorcontroller/index&success=2');
        exit;
    }

    public function createrelation()
    {
        $codigo = $_POST['codigo'];
        $area = $_POST['area'];
        $materia = $_POST['materia'];

        if (!$this->profesorDAO->crearRelacion($codigo, $materia, $area)) {
            header('Location: ' . BASE_URL . 'index.php?url=Profesorcontroller/index&error=duplicado');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?url=Profesorcontroller/index&success=3');
        exit;
    }
}