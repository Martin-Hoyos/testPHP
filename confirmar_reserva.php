<?php
session_start();

// Configuración de la conexión a la base de datos
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

// Obtener datos del usuario desde la sesión
$usuario = $_SESSION['usuario'];

// Obtener y sanitizar los datos del formulario
$lugar = $_POST['lugar'] ?? '';
$fechaEntrada = $_POST['fecha_entrada'] ?? '';
$fechaSalida = $_POST['fecha_salida'] ?? '';
$habitacion_id = $_POST['numero_habitacion'] ?? '';

if (empty($lugar) || empty($fechaEntrada) || empty($fechaSalida) || empty($habitacion_id)) {
    die("Error: faltan parámetros requeridos.");
}

// Comprobar si la habitación ya está reservada en esas fechas
$stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM Reservadas WHERE numero_habitacion = ? 
                            AND (fecha_entrada BETWEEN ? AND ? OR fecha_salida BETWEEN ? AND ?)");
$stmtCheck->execute([$habitacion_id, $fechaEntrada, $fechaSalida, $fechaEntrada, $fechaSalida]);
$existeReserva = $stmtCheck->fetchColumn();

if ($existeReserva > 0) {
    die("Error: La habitación ya está reservada en estas fechas.");
}

// Insertar la reserva en la base de datos
try {
    $stmt = $pdo->prepare("INSERT INTO reservas (numero_habitacion, nombre_cliente, apellidos_cliente, email, numero_telefono, fecha_entrada, fecha_salida, lugar) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $habitacion_id,
        $usuario['nombre'],
        $usuario['apellidos'],
        $usuario['email'],
        $usuario['telefono'],
        $fechaEntrada,
        $fechaSalida,
        $lugar
    ]);

    echo "Reserva confirmada con éxito. <a href='index.php'>Volver al inicio</a>";
} catch (PDOException $e) {
    die("Error al registrar la reserva: " . $e->getMessage());
}
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
