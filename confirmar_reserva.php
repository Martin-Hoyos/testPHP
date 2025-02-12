<?php
session_start();
$host = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
$dbname = "bew3kbjtj9n5faq31kla";
$dbUsername = "ueaxccosiwgfnuo5";
$dbPassword = "J9d5wTPIyWsgRyXmEJfd";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    die("Debes iniciar sesión para reservar.");
}

$lugar = $_GET['lugar'] ?? '';
$fechaEntrada = $_GET['fechaEntrada'] ?? '';
$fechaSalida = $_GET['fechaSalida'] ?? '';
$habitacion_id = $_GET['id'] ?? '';

if (empty($lugar) || empty($fechaEntrada) || empty($fechaSalida) || empty($habitacion_id)) {
    die("Error: faltan parámetros requeridos.");
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Reserva</title>
    <link rel="stylesheet" href="styles/reserva.css">
</head>
<body>
<h2>Confirmar Reserva</h2>

<form action="procesar_reserva.php" method="POST">
    <input type="hidden" name="numero_habitacion" value="<?= htmlspecialchars($habitacion_id) ?>">
    <input type="hidden" name="lugar" value="<?= htmlspecialchars($lugar) ?>">
    <input type="hidden" name="fecha_entrada" value="<?= htmlspecialchars($fechaEntrada) ?>">
    <input type="hidden" name="fecha_salida" value="<?= htmlspecialchars($fechaSalida) ?>">

    <label>Nombre</label>
    <input type="text" name="nombre_cliente" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

    <label>Apellidos</label>
    <input type="text" name="apellidos_cliente" value="<?= htmlspecialchars($usuario['apellidos']) ?>" required>

    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

    <label>Teléfono</label>
    <input type="text" name="numero_telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>" required>

    <button type="submit">Confirmar Reserva</button>
</form>
</body>
</html>
