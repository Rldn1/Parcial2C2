<?php
session_start();
require_once 'conexion.php';

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
    <title>Farmacias la Buena - Asistencia Médica</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Farmacias la Buena - Asistencia Médica</h1>
            <div>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <span>Hola, <?php echo $_SESSION['username']; ?></span>
                    <a href="dashboard.php" class="btn btn-primary">Panel Admin</a>
                    <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
                <?php endif; ?>
            </div>
        </header>

        <h2>Listado de Citas Médicas</h2>
        
        <?php if(count($citas) > 0): ?>
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
                </tr>
            </thead>
            <tbody>
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
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <div class="error">No hay citas registradas aún</div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php $conexion->close(); ?>