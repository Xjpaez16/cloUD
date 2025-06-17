<?php
class Conexion {
    private $host = 'localhost';
    private $db = 'cloud';
    private $user = 'root';
    private $pass = '123456';
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->conn->connect_error) {
            die('Error de conexión a la base de datos: ' . $this->conn->connect_error);
        }
        $this->conn->set_charset('utf8');
    }

    public function getConexion() {
        return $this->conn;
    }

    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

}