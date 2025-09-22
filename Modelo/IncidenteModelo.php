<?php
require_once "conexion.php";

class IncidenteModelo {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function obtenerIncidentes() {
        $stmt = $this->db->prepare("SELECT i.*, e.nombres AS empleado, a.nombre AS area
                                    FROM incidente i
                                    JOIN empleado e ON i.id_incidente = e.id_empleado
                                    JOIN area a ON i.id_incidente = a.id_area");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEmpleados() {
        return $this->db->query("SELECT * FROM empleado")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerAreas() {
        return $this->db->query("SELECT * FROM area")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearIncidente($fecha, $descripcion) {
        $stmt = $this->db->prepare("INSERT INTO incidente (fecha_hora, descripcion)
                                    VALUES (?, ?)");
        return $stmt->execute([$fecha, $descripcion]);
    }

    public function actualizarIncidente($id, $fecha, $descripcion, $id_area) {
        $stmt = $this->db->prepare("UPDATE incidente SET fecha_hora = ?, descripcion = ? 
                                     , id_area = ? WHERE id = ?");
        return $stmt->execute([$fecha, $descripcion, $id_area, $id]);
    }

    public function eliminarIncidente($id) {
        $stmt = $this->db->prepare("DELETE FROM incidente WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
