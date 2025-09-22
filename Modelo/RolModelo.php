<?php
require_once "conexion.php";

class RolModelo {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function obtenerRoles() {
        return $this->db->query("SELECT * FROM rol")->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
