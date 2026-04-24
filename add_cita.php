<?php
session_start();
require_once 'conexion.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$medicos = ['Dra. Ana García', 'Dr. José Rodríguez', 'Dra. Marta Sánchez', 'Dr. Luis Pérez'];
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $paciente_nombre = trim($_POST['paciente_nombre']);
    $telefono = trim($_POST['telefono']);
    $medico = $_POST['medico'];
    $tipo_consulta = $_POST['tipo_consulta'];
    $fecha_cita = $_POST['fecha_cita'];
    $fecha_segunda_cita = !empty($_POST['fecha_segunda_cita']) ? $_POST['fecha_segunda_cita'] : null;
    $sintomas = trim($_POST['sintomas']);
    
    $errores = [];
    if(empty($paciente_nombre)) $errores[] = "Nombre del paciente requerido";
    if(empty($telefono)) $errores[] = "Teléfono requerido";
    if(empty($medico)) $errores[] = "Seleccione un médico";
    if(empty($tipo_consulta)) $errores[] = "Seleccione tipo de consulta";
    if(empty($fecha_cita)) $errores[] = "Fecha de cita requerida";
    
    if(empty($errores)) {
        $stmt = $conexion->prepare("INSERT INTO citas_medicas (paciente_nombre, telefono, medico, tipo_consulta, fecha_cita, fecha_segunda_cita, sintomas) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $paciente_nombre, $telefono, $medico, $tipo_consulta, $fecha_cita, $fecha_segunda_cita, $sintomas);
        
        if($stmt->execute()) {
            // Redirigir al dashboard después de guardar
            header("Location: dashboard.php?mensaje=created");
            exit();
        } else {
            $error = "Error al guardar la cita";
        }
        $stmt->close();
    } else {
        $error = implode("<br>", $errores);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Cita Médica</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>Registrar Nueva Cita</h2>
            
            <?php if($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <label>Nombre completo del paciente:</label>
                <input type="text" name="paciente_nombre" required>
                
                <label>Teléfono de contacto:</label>
                <input type="tel" name="telefono" required>
                
                <label>Seleccione médico:</label>
                <select name="medico" required>
                    <option value="">-- Seleccione un médico --</option>
                    <?php foreach($medicos as $med): ?>
                        <option value="<?php echo $med; ?>"><?php echo $med; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <label>Tipo de consulta:</label>
                <div class="radio-group">
                    <input type="radio" name="tipo_consulta" value="General" required> General
                    <input type="radio" name="tipo_consulta" value="Especialista"> Especialista
                </div>
                
                <label>Fecha de primera cita:</label>
                <input type="date" name="fecha_cita" required>
                
                <label>Fecha de segunda cita (opcional):</label>
                <input type="date" name="fecha_segunda_cita">
                <small class="hint">Puede quedar vacío</small>
                
                <label>Síntomas (opcional):</label>
                <textarea name="sintomas" rows="3" placeholder="Describa los síntomas..."></textarea>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Guardar Cita</button>
                    <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php $conexion->close(); ?>