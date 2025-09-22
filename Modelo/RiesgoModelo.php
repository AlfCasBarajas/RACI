<?php
require_once "conexion.php";

class RiesgoModelo {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function obtenerRiesgos() {
        $stmt = $this->db->prepare("SELECT r.*, a.nombre AS area, c.nombre AS categoria
                                    FROM riesgos r
                                    JOIN area a ON r.id_area = a.id
                                    JOIN categorias c ON r.id_categoria = c.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerAreas() {
        return $this->db->query("SELECT * FROM area")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerCategorias() {
        return $this->db->query("SELECT * FROM categorias")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearRiesgo($descripcion, $nivel, $id_area, $id_categoria) {
        $stmt = $this->db->prepare("INSERT INTO riesgos (descripcion, nivel, id_area, id_categoria)
                                    VALUES (?, ?, ?, ?)");
        return $stmt->execute([$descripcion, $nivel, $id_area, $id_categoria]);
    }

    public function actualizarRiesgo($id, $descripcion, $nivel, $id_area, $id_categoria) {
        $stmt = $this->db->prepare("UPDATE riesgos SET descripcion = ?, nivel = ?, id_area = ?, id_categoria = ? WHERE id = ?");
        return $stmt->execute([$descripcion, $nivel, $id_area, $id_categoria, $id]);
    }

    public function eliminarRiesgo($id) {
        $stmt = $this->db->prepare("DELETE FROM riesgos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
