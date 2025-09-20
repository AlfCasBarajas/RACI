<?php
require_once __DIR__ . '/../core/Database.php';

class Rol {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }
    public function getAll() {
        $conn = $this->db->getConnection();
        $stmt = $conn->query('SELECT * FROM rol');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Métodos para crear, editar y eliminar roles se agregarán después
}
