// Usuarios creados desde acá (este código) para encriptar las contraseñas con password_hash() y no tener que hacerlo manualmente en la base de datos


<?php
require_once 'conexion.php';

$usuarios = [
    ['admin', 'admin@farmacia.com', 'admin123', 'admin'],
    ['juan_perez', 'juan@farmacia.com', 'user123', 'user'],
    ['maria_gomez', 'maria@farmacia.com', 'user123', 'user'],
    ['carlos_ramirez', 'carlos@farmacia.com', 'user123', 'user'],
    ['laura_martinez', 'laura@farmacia.com', 'user123', 'user']
];

foreach($usuarios as $user) {
    $username = $user[0];
    $email = $user[1];
    $password = password_hash($user[2], PASSWORD_DEFAULT);
    $rol = $user[3];
    
    $stmt = $conexion->prepare("INSERT INTO usuarios (username, email, password, rol) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $rol);
    $stmt->execute();
    $stmt->close();
}

echo "Usuarios insertados correctamente";
$conexion->close();
?>


