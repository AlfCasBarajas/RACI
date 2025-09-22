<?php
require_once "conexion.php";

class InspeccionModelo {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function obtenerInspecciones() {
        $stmt = $this->db->prepare("SELECT i.*, a.nombre AS area 
                                    FROM inspecciones i 
                                    JOIN area a ON i.id_area = a.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerAreas() {
        return $this->db->query("SELECT * FROM area")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearInspeccion($fecha, $observacion, $id_area) {
        $stmt = $this->db->prepare("INSERT INTO inspecciones (fecha, observacion, id_area)
                                    VALUES (?, ?, ?)");
        return $stmt->execute([$fecha, $observacion, $id_area]);
    }

    public function actualizarInspeccion($id, $fecha, $observacion, $id_area) {
        $stmt = $this->db->prepare("UPDATE inspecciones SET fecha = ?, observacion = ?, id_area = ? WHERE id = ?");
        return $stmt->execute([$fecha, $observacion, $id_area, $id]);
    }

    public function eliminarInspeccion($id) {
        $stmt = $this->db->prepare("DELETE FROM inspecciones WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
