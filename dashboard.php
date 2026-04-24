<?php
session_start();
require_once 'conexion.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$mensaje = '';
if(isset($_GET['mensaje'])) {
    if($_GET['mensaje'] == 'created') {
        $mensaje = '<div class="success">Cita creada exitosamente</div>';
    } elseif($_GET['mensaje'] == 'updated') {
        $mensaje = '<div class="success">Cita actualizada exitosamente</div>';
    } elseif($_GET['mensaje'] == 'deleted') {
        $mensaje = '<div class="success">Cita eliminada exitosamente</div>';
    }
}

// Obtener citas ordenadas por ID (ascendente)
$citas = [];
$result = $conexion->query("SELECT * FROM citas_medicas ORDER BY id ASC");
if($result) {
    $citas = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Panel de Administración</h1>
            <div>
                <span>Bienvenido, <strong><?php echo $_SESSION['username']; ?></strong></span>
                <a href="add_cita.php" class="btn btn-success">Nueva Cita</a>
                <a href="index.php" class="btn btn-secondary">Ver Página Pública</a>
                <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </header>

        <h2>Gestión de Citas Médicas</h2>
        
        <?php echo $mensaje; ?>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Teléfono</th>
                    <th>Médico</th>
                    <th>Tipo Consulta</th>
                    <th>Fecha Cita</th>
                    <th>2da Cita</th>
                    <th>Síntomas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($citas) > 0): ?>
                    <?php foreach($citas as $cita): ?>
                    <tr>
                        <td><?php echo $cita['id']; ?></td>
                        <td><?php echo htmlspecialchars($cita['paciente_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($cita['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($cita['medico']); ?></td>
                        <td><?php echo htmlspecialchars($cita['tipo_consulta']); ?></td>
                        <td><?php echo htmlspecialchars($cita['fecha_cita']); ?></td>
                        <td><?php echo $cita['fecha_segunda_cita'] ? htmlspecialchars($cita['fecha_segunda_cita']) : '—'; ?></td>
                        <td><?php echo htmlspecialchars($cita['sintomas']); ?></td>
                        <td>
                            <a href="edit_cita.php?id=<?php echo $cita['id']; ?>" class="btn btn-warning">Editar</a>
                            <a href="delete_cita.php?id=<?php echo $cita['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Eliminar esta cita?')">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align: center;">No hay citas registradas</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php $conexion->close(); ?>