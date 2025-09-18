
<?php
require_once __DIR__ . '/../core/Database.php';

function crearUsuariosIniciales() {
    $db = new Database();
    $conn = $db->getConnection();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $usuarios = [
        ['num_doc' => 1, 'tipo_doc' => 'CC', 'nombres' => 'admin', 'apellidos' => 'Administrador', 'rol' => 1, 'contrasena' => password_hash('admin123', PASSWORD_DEFAULT), 'telefono' => 123456789],
        ['num_doc' => 2, 'tipo_doc' => 'CC', 'nombres' => 'super', 'apellidos' => 'Supervisor', 'rol' => 2, 'contrasena' => password_hash('456', PASSWORD_DEFAULT), 'telefono' => 234567890],
        ['num_doc' => 3, 'tipo_doc' => 'CC', 'nombres' => 'coord', 'apellidos' => 'Coordinador', 'rol' => 3, 'contrasena' => password_hash('789', PASSWORD_DEFAULT), 'telefono' => 345678901],
        ['num_doc' => 4, 'tipo_doc' => 'CC', 'nombres' => 'traba', 'apellidos' => 'Trabajador', 'rol' => 4, 'contrasena' => password_hash('369', PASSWORD_DEFAULT), 'telefono' => 456789012]
    ];
    foreach ($usuarios as $u) {
        try {
            $stmt = $conn->prepare('INSERT INTO user (num_doc, tipo_doc, nombres, apellidos, rol, contrasena, telefono) VALUES (:num_doc, :tipo_doc, :nombres, :apellidos, :rol, :contrasena, :telefono)');
            $stmt->execute([
                ':num_doc' => $u['num_doc'],
                ':tipo_doc' => $u['tipo_doc'],
                ':nombres' => $u['nombres'],
                ':apellidos' => $u['apellidos'],
                ':rol' => $u['rol'],
                ':contrasena' => $u['contrasena'],
                ':telefono' => $u['telefono']
            ]);
            echo "Usuario insertado: " . $u['nombres'] . "\n";
        } catch (PDOException $e) {
            echo "Error al insertar usuario " . $u['nombres'] . ": " . $e->getMessage() . "\n";
        }
    }
}

crearUsuariosIniciales();
