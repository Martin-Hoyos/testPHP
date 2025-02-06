<?php
session_start();

// Asigna valores usando el operador de fusión null para evitar warnings
$lugar = $_GET['lugar'] ?? '';
$fechaEntrada = $_GET['fechaEntrada'] ?? '';
$fechaSalida = $_GET['fechaSalida'] ?? '';
$id = $_GET['id'] ?? '';

// Opcional: validar que los datos obligatorios se hayan recibido
if (empty($lugar) || empty($fechaEntrada) || empty($fechaSalida) || empty($id)) {
    die("Error: faltan parámetros requeridos.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Reserva</title>
    <link rel="stylesheet" href="styles/reserva.css">
</head>
<body>
<h2>Confirmar Reserva</h2>

<form action="procesar_reserva.php" method="POST">
    <input type="hidden" name="numero_habitacion" value="<?= $numero_habitacion ?>">
    <input type="hidden" name="lugar" value="<?= $lugar ?>">
    <input type="hidden" name="fecha_entrada" value="<?= $fechaEntrada ?>">
    <input type="hidden" name="fecha_salida" value="<?= $fechaSalida ?>">

    <label>Nombre</label>
    <input type="text" name="nombre_cliente" value="<?= $nombre_cliente ?>" readonly>

    <label>Apellidos</label>
    <input type="text" name="apellidos_cliente" value="<?= $apellidos_cliente ?>" readonly>

    <label>Email</label>
    <input type="email" name="email" value="<?= $email ?>" readonly>

    <label>Teléfono</label>
    <input type="text" name="numero_telefono" value="<?= $numero_telefono ?>" readonly>

    <button type="submit">Confirmar Reserva</button>
</form>
</body>
</html>
