<?php
// Script para generar hashes de contraseñas correctos
echo "Generando hashes de contraseñas:\n\n";

$passwords = [
    'admin' => 'admin123',
    'super' => 'super123',
    'coord' => 'coord123',
    'traba' => 'traba123'
];

foreach ($passwords as $user => $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo "Usuario: $user\n";
    echo "Contraseña: $password\n";
    echo "Hash: $hash\n\n";
    
    echo "UPDATE user SET contrasena = '$hash' WHERE usuario = '$user';\n\n";
}
?>