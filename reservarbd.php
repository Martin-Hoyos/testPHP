<?php
session_start();
require_once 'config.php';

$nombre_cliente = isset($_SESSION['nombre_cliente']) ? $_SESSION['nombre_cliente'] : '';
$apellidos_cliente = isset($_SESSION['apellidos_cliente']) ? $_SESSION['apellidos_cliente'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$numero_telefono = isset($_SESSION['numero_telefono']) ? $_SESSION['numero_telefono'] : '';

$lugar = $_GET['lugar'];
$fechaEntrada = $_GET['fechaEntrada'];
$fechaSalida = $_GET['fechaSalida'];
$numero_habitacion = $_GET['id'];
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

<form action="includes/procesar_reserva.php" method="POST">
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
