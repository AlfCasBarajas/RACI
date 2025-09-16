<?php
require_once '../app/core/Database.php';

function crearUsuariosIniciales() {
    $db = new Database();
    $conn = $db->getConnection();
    $usuarios = [
        ['num_doc' => 1, 'tipo_doc' => 'CC', 'nombres' => 'admin', 'apellidos' => 'Administrador', 'rol' => 1, 'contraseña' => password_hash('admin123', PASSWORD_DEFAULT), 'telefono' => 123456789],
        ['num_doc' => 2, 'tipo_doc' => 'CC', 'nombres' => 'super', 'apellidos' => 'Supervisor', 'rol' => 2, 'contraseña' => password_hash('456', PASSWORD_DEFAULT), 'telefono' => 234567890],
        ['num_doc' => 3, 'tipo_doc' => 'CC', 'nombres' => 'coord', 'apellidos' => 'Coordinador', 'rol' => 3, 'contraseña' => password_hash('789', PASSWORD_DEFAULT), 'telefono' => 345678901],
        ['num_doc' => 4, 'tipo_doc' => 'CC', 'nombres' => 'traba', 'apellidos' => 'Trabajador', 'rol' => 4, 'contraseña' => password_hash('369', PASSWORD_DEFAULT), 'telefono' => 456789012]
    ];
    foreach ($usuarios as $u) {
        $stmt = $conn->prepare('INSERT INTO user (num_doc, tipo_doc, nombres, apellidos, rol, contraseña, telefono) VALUES (:num_doc, :tipo_doc, :nombres, :apellidos, :rol, :contraseña, :telefono)');
        $stmt->execute($u);
    }
}

function crearRolesIniciales() {
    $db = new Database();
    $conn = $db->getConnection();
    $roles = [
        ['nombre' => 'admin'],
        ['nombre' => 'supervisor'],
        ['nombre' => 'coordinador'],
        ['nombre' => 'trabajador']
    ];
    foreach ($roles as $r) {
        $stmt = $conn->prepare('INSERT INTO rol (nombre) VALUES (:nombre)');
        $stmt->execute($r);
    }
}

// Ejecutar solo una vez para poblar roles y usuarios
// crearRolesIniciales();
// crearUsuariosIniciales();
