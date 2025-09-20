<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Database.php';

class RolController extends Controller {
    public function index() {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->query('SELECT * FROM rol');
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include __DIR__ . '/../views/roles_list.php';
    }
    // Métodos para crear, editar y eliminar roles se agregarán después
}
