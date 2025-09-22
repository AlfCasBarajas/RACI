<?php
require_once "conexion.php";

class AccidenteModelo {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function obtenerAccidentes() {
        $stmt = $this->db->prepare("SELECT a.*, e.nombres AS empleado, ar.nombre AS area
                                    FROM accidente a
                                    JOIN empleado e ON a.id_accidente = e.id_empleado
                                    JOIN area ar ON a.id_accidente = ar.id_area");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEmpleados() {
        return $this->db->query("SELECT * FROM empleado")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerAreas() {
        return $this->db->query("SELECT * FROM area")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearAccidente($fecha, $descripcion, $id_empleado, $id_area) {
        $stmt = $this->db->prepare("INSERT INTO accidente (fecha_hora, descripcion, id_empleado, id_area)
                                    VALUES (?, ?, ?, ?)");
        return $stmt->execute([$fecha, $descripcion, $id_empleado, $id_area]);
    }

    public function actualizarAccidente($id, $fecha, $descripcion, $id_empleado, $id_area) {
        $stmt = $this->db->prepare("UPDATE accidente SET fecha_hora = ?, descripcion = ?, 
                                    id_empleado = ?, id_area = ? WHERE id = ?");
        return $stmt->execute([$fecha, $descripcion, $id_empleado, $id_area, $id]);
    }

    public function eliminarAccidente($id) {
        $stmt = $this->db->prepare("DELETE FROM accidente WHERE id_accidente = ?");
        return $stmt->execute([$id]);
    }
}
?>
