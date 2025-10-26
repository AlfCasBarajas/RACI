<?php
// Script para verificar el hash de una contraseña y generar uno nuevo

$password_admin = 'admin123';
$password_coord = 'coord123';
$password_super = 'super123';
$password_traba = 'traba123';

// Generar hash
$hash_admin = password_hash($password_admin, PASSWORD_DEFAULT);
$hash_coord = password_hash($password_coord, PASSWORD_DEFAULT);
$hash_super = password_hash($password_super, PASSWORD_DEFAULT);
$hash_traba = password_hash($password_traba, PASSWORD_DEFAULT);

echo "Hash admin123: $hash_admin<br>";
echo "Hash coord123: $hash_coord<br>";
echo "Hash super123: $hash_super<br>";
echo "Hash traba123: $hash_traba<br>";

// Verificar hash (ejemplo)
$hash_ejemplo = '$2y$10$Q9QwQwQwQwQwQwQwQwQwQOQwQwQwQwQwQwQwQwQwQwQwQwQwQwQwQwQwQwQwQwQwQw'; // Reemplaza por el hash real de tu base de datos
if (password_verify($password_admin, $hash_ejemplo)) {
    echo "La contraseña admin123 coincide con el hash.<br>";
} else {
    echo "La contraseña admin123 NO coincide con el hash n.<br>";
}
?>
