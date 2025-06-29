<?php
class FilesController
{
    private $ProfesorDAO;
    private $areaDAO;

    private $materiaDAO;
    private $archivoDAO;
    private $s3;
    private $archivoDTO;


    public function __construct()
    {
        require_once(__DIR__ . '/models/DAO/ProfesorDAO.php');
        require_once(__DIR__ . '/models/DAO/AreaDAO.php');
        require_once(__DIR__ . '/models/DAO/MateriaDAO.php');
        require_once(__DIR__ . '/models/DAO/S3DAO.php');
        require_once(__DIR__ . '/models/DAO/ArchivoDAO.php');
        require_once(__DIR__ . '/models/DTO/ArchivoDTO.php');
        require_once(__DIR__ . '/models/DTO/EstudianteDTO.php');

        $this->ProfesorDAO = new ProfesorDAO;
        $this->areaDAO = new AreaDAO;
        $this->materiaDAO = new MateriaDAO;
        $this->archivoDAO = new ArchivoDAO;
        $this->s3 = new S3DAO;
        $this->archivoDTO = new ArchivoDTO;
    }
    public function viewteachers()
    {
        $profesores = $this->ProfesorDAO->listteachers();
        return $profesores;
    }

    public function viewareas()
    {
        $areas = $this->areaDAO->listarea();
        return $areas;
    }
    public function viewmaterias()
    {
        $materias = $this->materiaDAO->listmaterias();
        return $materias;
    }

    public function viewareasup()
    {
        $profesorid = $_GET['profesorid'];
        $areas = $this->areaDAO->getAreabyteacher($profesorid);
        $areasArray = [];

        foreach ($areas as $area) {
            $areasArray[] = [
                'codigo' => $area->getCodigo(),
                'nombre' => $area->getNombre()
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($areasArray);
    }
    public function viewmateriasup()
    {
        $areaid = $_GET['areacodigo'];
        $materias = $this->materiaDAO->getMateriasByArea($areaid);
        $materiasArray = [];

        foreach ($materias as $materia) {
            $materiasArray[] = [
                'id' => $materia->getId(),
                'nombre' => $materia->getNom_materia()
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($materiasArray);
    }
    public function viewfiles()
    {

        $archivosS3  = $this->s3->viewfiles();
        $archivos = $this->archivoDAO->allfiles($archivosS3);
        return $archivos;
    }
    public function uploadfiles()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
        $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
        if ($rol == 'estudiante') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {
                $s3 = new S3DAO();
                $resultado = $s3->uploadFile($_FILES['archivo']);
                $profesor = $_POST['profesor'];
                $area = $_POST['area'];
                $materia = $_POST['materia'];
                $id_tipo = $this->archivoDAO->verificartipo($resultado->getTipo());
                error_log('verificando tipo = ' . $id_tipo);
                $this->archivoDTO->setNombre($resultado->getNombre());
                $this->archivoDTO->setRuta($resultado->getUrl());
                $this->archivoDTO->setTamano($resultado->getTamaño());
                $this->archivoDTO->setCod_profesor($profesor);
                $this->archivoDTO->setCod_area($area);
                $this->archivoDTO->setId_materia($materia);
                $this->archivoDTO->setCod_estudiante($usuario->getCodigo());
                $this->archivoDTO->setCod_Tutor(null);
                $this->archivoDTO->setCod_estado(7);
                if ($id_tipo) {

                    $this->archivoDTO->setId_tipo($id_tipo);
                    error_log("Mostrando TIPO ARCHIVO :" . $this->archivoDTO->getId_tipo());
                } else {
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/uploadfiles&error=1');
                }
                error_log("Mostrando :" . $this->archivoDTO->getNombre());
                error_log("Mostrando :" . $this->archivoDTO->getRuta());
                error_log("Mostrando :" . $this->archivoDTO->getTamano());
                error_log("Mostrando :" . $this->archivoDTO->getCod_profesor());
                error_log("Mostrando :" . $this->archivoDTO->getCod_area());
                error_log("Mostrando :" . $this->archivoDTO->getId_materia());
                error_log("Mostrando :" . $this->archivoDTO->getCod_estudiante());
                error_log("Mostrando :" . $this->archivoDTO->getCod_Tutor());
                error_log("Mostrando :" . $this->archivoDTO->getCod_estado());
                error_log("Mostrando :" . $this->archivoDTO->getId_tipo());
                $upFile = $this->archivoDAO->create($this->archivoDTO);
                if ($resultado &&  $upFile) {
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/dashboardfiles&success=1');
                    exit;
                } else {
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/uploadfiles&error=2');
                }
            }
        } elseif ($rol == 'tutor') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {
                $s3 = new S3DAO();
                $resultado = $s3->uploadFile($_FILES['archivo']);
                $profesor = $_POST['profesor'];
                $area = $_POST['area'];
                $materia = $_POST['materia'];
                $id_tipo = $this->archivoDAO->verificartipo($resultado->getTipo());
                error_log('verificando tipo = ' . $id_tipo);
                $this->archivoDTO->setNombre($resultado->getNombre());
                $this->archivoDTO->setRuta($resultado->getUrl());
                $this->archivoDTO->setTamano($resultado->getTamaño());
                $this->archivoDTO->setCod_profesor($profesor);
                $this->archivoDTO->setCod_area($area);
                $this->archivoDTO->setId_materia($materia);
                $this->archivoDTO->setCod_estudiante(null);
                $this->archivoDTO->setCod_Tutor($usuario->getCodigo());
                $this->archivoDTO->setCod_estado(7);
                if ($id_tipo) {

                    $this->archivoDTO->setId_tipo($id_tipo);
                    error_log("Mostrando TIPO ARCHIVO :" . $this->archivoDTO->getId_tipo());
                } else {
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/uploadfiles&error=1');
                }
                error_log("Mostrando :" . $this->archivoDTO->getNombre());
                error_log("Mostrando :" . $this->archivoDTO->getRuta());
                error_log("Mostrando :" . $this->archivoDTO->getTamano());
                error_log("Mostrando :" . $this->archivoDTO->getCod_profesor());
                error_log("Mostrando :" . $this->archivoDTO->getCod_area());
                error_log("Mostrando :" . $this->archivoDTO->getId_materia());
                error_log("Mostrando :" . $this->archivoDTO->getCod_estudiante());
                error_log("Mostrando :" . $this->archivoDTO->getCod_Tutor());
                error_log("Mostrando :" . $this->archivoDTO->getCod_estado());
                error_log("Mostrando :" . $this->archivoDTO->getId_tipo());
                $upFile = $this->archivoDAO->create($this->archivoDTO);
                if ($resultado &&  $upFile) {
                    header('Location: ' . BASE_URL . 'index.php?url=RouteController/dashboardfiles&success=1');
                    exit;
                }
            }
        }
    }
    public function myfiles()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
        $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
        if ($rol == 'estudiante') {
            $archivosS3  = $this->s3->viewfiles();
            $archivosest = $this->archivoDAO->getMyFilesStudent($usuario->getCodigo(), $archivosS3);
            error_log("rol = " . $rol);
            return $archivosest;
        } elseif ($rol == 'tutor') {
            $archivosS3  = $this->s3->viewfiles();
            $archivosest = $this->archivoDAO->getMyFilesTutor($usuario->getCodigo(), $archivosS3);
            error_log("rol = " . $rol);
            return $archivosest;
        }
    }
    public function updatefile()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $this->archivoDTO->setCod_profesor($_POST['profesor']);
            $this->archivoDTO->setCod_area($_POST['area']);
            $this->archivoDTO->setId_materia($_POST['materia']);
            $this->archivoDTO->setCod_estado($_POST['estado']);

            $editado = $this->archivoDAO->updateFile($id, $this->archivoDTO);

            if ($editado) {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/viewmyfilesStudent&success=1');
            } else {
                header('Location: ' . BASE_URL . 'index.php?url=RouteController/viewmyfilesStudent&error=1');
            }
        }
    }
}
