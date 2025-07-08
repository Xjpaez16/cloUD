<?php
class TipoArchivoAdminController {
    private $dao;

    public function __construct() {
        require_once(__DIR__ . '/models/DTO/Tipo_archivoDTO.php');
        require_once(__DIR__ . '/models/DAO/Tipo_archivoDAO.php');
        $this->dao = new Tipo_archivoDAO();
    }

    public function index() {
        $tipos = $this->dao->obtenerTodos();
        $data = ['tipos' => $tipos];
        require __DIR__ . '/../../view/tipoarchivo_crud.php';
    }


    public function create() {
        $codigo = $_POST['codigo'];
        $nombre = trim($_POST['nombre']);
        $nombre= strtoupper($nombre);

        if ($this->dao->existeCodigo($codigo)) {
            header('Location: ' . BASE_URL . 'index.php?url=TipoArchivoAdminController/index&error=idduplicado');
            exit;
        }

        if ($this->dao->existeNombre($nombre)) {
            header('Location: ' . BASE_URL . 'index.php?url=TipoArchivoAdminController/index&error=nombreduplicado');
            exit;
        }

        if (!$this->dao->crear($codigo, $nombre)) {
            header('Location: ' . BASE_URL . 'index.php?url=TipoArchivoAdminController/index&error=creacionfallida');
            exit;
        }
        
        header('Location: ' . BASE_URL . 'index.php?url=TipoArchivoAdminController/index&success=1');
        exit;
    }

    // Actualiza un tipo de archivo
    public function update() {
        $codigo_actual = $_POST['codigo_actual'];
        $nuevo_codigo = $_POST['codigo'];
        $nombre = trim($_POST['nombre']);
        $nombre= strtoupper($nombre);
        if ($codigo_actual != $nuevo_codigo && $this->dao->existeCodigo($nuevo_codigo)) {
            header('Location: ' . BASE_URL . 'index.php?url=TipoArchivoAdminController/index&error=idyausado');
            exit;
        }

        if ($this->dao->existeNombreEnOtro($nombre, $codigo_actual)) {
            header('Location: ' . BASE_URL . 'index.php?url=TipoArchivoAdminController/index&error=nombreyausado');
            exit;
        }
        error_log("Actualización exitosa"); // Verifica en el log de errores
        $this->dao->actualizar($codigo_actual, $nuevo_codigo, $nombre);
        header('Location: ' . BASE_URL . 'index.php?url=TipoArchivoAdminController/index&success=2');
        exit;
    }

}
?>