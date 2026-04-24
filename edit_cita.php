<?php
session_start();
require_once 'conexion.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$medicos = ['Dra. Ana García', 'Dr. José Rodríguez', 'Dra. Marta Sánchez', 'Dr. Luis Pérez'];
$error = '';

$id = $_GET['id'] ?? 0;

$stmt = $conexion->prepare("SELECT * FROM citas_medicas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$cita = $result->fetch_assoc();

if(!$cita) {
    header("Location: dashboard.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $paciente_nombre = trim($_POST['paciente_nombre']);
    $telefono = trim($_POST['telefono']);
    $medico = $_POST['medico'];
    $tipo_consulta = $_POST['tipo_consulta'];
    $fecha_cita = $_POST['fecha_cita'];
    $fecha_segunda_cita = !empty($_POST['fecha_segunda_cita']) ? $_POST['fecha_segunda_cita'] : null;
    $sintomas = trim($_POST['sintomas']);
    
    $stmt = $conexion->prepare("UPDATE citas_medicas SET paciente_nombre=?, telefono=?, medico=?, tipo_consulta=?, fecha_cita=?, fecha_segunda_cita=?, sintomas=? WHERE id=?");
    $stmt->bind_param("sssssssi", $paciente_nombre, $telefono, $medico, $tipo_consulta, $fecha_cita, $fecha_segunda_cita, $sintomas, $id);
    
    if($stmt->execute()) {
        // Redirigir al dashboard después de editar
        header("Location: dashboard.php?mensaje=updated");
        exit();
    } else {
        $error = "Error al actualizar";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cita</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>Editar Cita Médica</h2>
            
            <?php if($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <label>Nombre completo del paciente:</label>
                <input type="text" name="paciente_nombre" value="<?php echo htmlspecialchars($cita['paciente_nombre']); ?>" required>
                
                <label>Teléfono de contacto:</label>
                <input type="tel" name="telefono" value="<?php echo htmlspecialchars($cita['telefono']); ?>" required>
                
                <label>Seleccione médico:</label>
                <select name="medico" required>
                    <?php foreach($medicos as $med): ?>
                        <option value="<?php echo $med; ?>" <?php echo ($cita['medico'] == $med) ? 'selected' : ''; ?>><?php echo $med; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <label>Tipo de consulta:</label>
                <div class="radio-group">
                    <input type="radio" name="tipo_consulta" value="General" <?php echo ($cita['tipo_consulta'] == 'General') ? 'checked' : ''; ?>> General
                    <input type="radio" name="tipo_consulta" value="Especialista" <?php echo ($cita['tipo_consulta'] == 'Especialista') ? 'checked' : ''; ?>> Especialista
                </div>
                
                <label>Fecha de primera cita:</label>
                <input type="date" name="fecha_cita" value="<?php echo $cita['fecha_cita']; ?>" required>
                
                <label>Fecha de segunda cita (opcional):</label>
                <input type="date" name="fecha_segunda_cita" value="<?php echo $cita['fecha_segunda_cita']; ?>">
                
                <label>Síntomas:</label>
                <textarea name="sintomas" rows="3"><?php echo htmlspecialchars($cita['sintomas']); ?></textarea>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php $conexion->close(); ?>