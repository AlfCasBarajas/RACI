<?php
require_once "conexion.php";

class EmpleadoModelo {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function obtenerEmpleados() {
        $stmt = $this->db->prepare("SELECT e.*, a.nombre AS area 
                                    FROM empleado e 
                                    JOIN area a ON e.id_empleado ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerAreas() {
        return $this->db->query("SELECT * FROM area")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearEmpleado($nombre, $documento, $cargo) {
        $stmt = $this->db->prepare("INSERT INTO empleado (nombres, tipo_doc, cargo_funcion)
                                    VALUES (?, ?, ?)");
        return $stmt->execute([$nombre, $documento, $cargo]);
    }

    public function actualizarEmpleado($id, $nombre, $documento, $cargo) {
        $stmt = $this->db->prepare("UPDATE empleado SET nombres = ?, tipo_doc = ?, cargo_funcion = ?  WHERE id_empleado = ?");
        return $stmt->execute([$nombre, $documento, $cargo, $id]);
    }

    public function eliminarEmpleado($id) {
        $stmt = $this->db->prepare("DELETE FROM empleado WHERE id_empleado = ?");
        return $stmt->execute([$id]);
    }
}
?>
