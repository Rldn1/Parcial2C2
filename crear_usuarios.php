// Usuarios creados desde acá (este código) para encriptar las contraseñas con password_hash() y no tener que hacerlo manualmente en la base de datos


<?php
require_once 'conexion.php';

$usuarios = [
    ['admin', 'admin123', 'admin'],
    ['juan_perez', 'user123', 'user'],
    ['maria_gomez', 'user123', 'user'],
    ['carlos_ramirez', 'user123', 'user'],
    ['laura_martinez', 'user123', 'user']
];

foreach($usuarios as $user) {
    $username = $user[0];
    $password = password_hash($user[1], PASSWORD_DEFAULT);
    $rol = $user[2];
    
    $stmt = $conexion->prepare("INSERT INTO usuarios (username, password, rol) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $rol);
    $stmt->execute();
    $stmt->close();
}

echo "Usuarios insertados correctamente";
$conexion->close();
?>



