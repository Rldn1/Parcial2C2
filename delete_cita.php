<?php
session_start();
require_once 'conexion.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? 0;

$stmt = $conexion->prepare("DELETE FROM citas_medicas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: dashboard.php?mensaje=deleted");
exit();

$conexion->close();
?>