<?php
session_start();
require_once 'conexion.php';

$lugar = $_GET['lugar'] ?? '';
$fechaEntrada = $_GET['fechaEntrada'] ?? '';
$fechaSalida = $_GET['fechaSalida'] ?? '';
$habitacion_id = $_GET['id'] ?? '';

if (empty($lugar) || empty($fechaEntrada) || empty($fechaSalida) || empty($habitacion_id)) {
    die("Error: faltan parámetros requeridos.");
}

$usuario = $_SESSION['usuario'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Reserva</title>
</head>
<body>
<h2>Confirmar Reserva</h2>

<form action="procesar_reserva.php" method="POST">
    <input type="hidden" name="numero_habitacion" value="<?= $habitacion_id ?>">
    <input type="hidden" name="lugar" value="<?= $lugar ?>">
    <input type="hidden" name="fecha_entrada" value="<?= $fechaEntrada ?>">
    <input type="hidden" name="fecha_salida" value="<?= $fechaSalida ?>">

    <label>Nombre</label>
    <input type="text" name="nombre_cliente" value="<?= $usuario['nombre'] ?? '' ?>" required>

    <label>Apellidos</label>
    <input type="text" name="apellidos_cliente" value="<?= $usuario['apellidos'] ?? '' ?>" required>

    <label>Email</label>
    <input type="email" name="email" value="<?= $usuario['email'] ?? '' ?>" required>

    <label>Teléfono</label>
    <input type="text" name="numero_telefono" value="<?= $usuario['telefono'] ?? '' ?>" required>

    <button type="submit">Confirmar Reserva</button>
</form>
</body>
</html>
