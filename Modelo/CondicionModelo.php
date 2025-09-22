<?php
require_once "conexion.php";

class CondicionModelo {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function obtenerCondiciones() {
        $stmt = $this->db->prepare("SELECT c.*, a.nombre AS area
                                    FROM condicion_insegura c
                                    JOIN area a ON c.id_cond_inseg = a.id_area");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerAreas() {
        return $this->db->query("SELECT * FROM area")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearCondicion( $nombre,$descripcion) {
        $stmt = $this->db->prepare("INSERT INTO condicion_insegura (nombre, descripcion)
                                    VALUES (?, ?)");
        return $stmt->execute([$nombre,$descripcion]);
    }

    public function actualizarCondicion($id, $descripcion) {
        $stmt = $this->db->prepare("UPDATE condicion_insegura SET  descripcion = ? WHERE id_cond_inseg = ?");
        return $stmt->execute([$descripcion, $id]);
    }

    public function eliminarCondicion($id) {
        $stmt = $this->db->prepare("DELETE FROM condicion_insegura WHERE id_cond_inseg = ?");
        return $stmt->execute([$id]);
    }
}
?>
