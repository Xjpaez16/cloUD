<?php
class adminController {
    private $adminDAO;
    
    public function __construct() {
        require_once(__DIR__ . '/models/DAO/AdminDAO.php');
        $this->adminDAO = new AdminDAO();
    }
    
    public function obtenerAdmin() {
        return $this->adminDAO->obtenerAdminPorId(1);
    }
}
?>
