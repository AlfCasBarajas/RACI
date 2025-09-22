<?php
require_once "conexion.php";

class UsuarioModelo {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function obtenerUsuarios() {
        $stmt = $this->db->prepare("SELECT u.*, r.nombre AS rol 
                                    FROM user u 
                                    JOIN rol r ON u.rol = r.id_Rol");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerRoles() {
        return $this->db->query("SELECT * FROM rol")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearUsuario($nombres, $apellidos, $num_doc, $contrasena, $rol) {
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO user (nombres, apellidos, num_doc, contrasena, rol)
                                    VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$nombres, $apellidos, $num_doc, $hash, $rol]);
    }

    public function actualizarUsuario($id, $nombres, $apellidos, $num_doc, $rol) {
        $stmt = $this->db->prepare("UPDATE user SET nombres = ?, apellidos = ?, num_doc = ?, rol = ? WHERE num_doc = ?");
        return $stmt->execute([$nombres, $apellidos, $num_doc, $rol, $id]);
    }

    public function eliminarUsuario($id) {
        $stmt = $this->db->prepare("DELETE FROM user WHERE num_doc = ?");
        return $stmt->execute([$id]);
    }
}
?>
