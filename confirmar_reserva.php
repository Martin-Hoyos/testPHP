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

// Verificar si el usuario ha iniciado sesión y si la sesión tiene datos
if (!isset($_SESSION['usuario']) || !is_array($_SESSION['usuario'])) {
    die("ERROR: No has iniciado sesión. <a href='Login.html'>Inicia sesión</a>");
}

// Mostrar la sesión para comprobar los datos del usuario
echo "<pre>";
print_r($_SESSION['usuario']);
echo "</pre>";

// Obtener datos del usuario desde la sesión
$usuario = $_SESSION['usuario'];
$nombre = $usuario['nombre'] ?? 'Sin nombre';
$apellidos = $usuario['apellidos'] ?? 'Sin apellidos';
$email = $usuario['email'] ?? 'Sin email';
$telefono = $usuario['telefono'] ?? 'Sin teléfono';

// Obtener y sanitizar los datos del formulario
$lugar = $_POST['lugar'] ?? '';
$fechaEntrada = $_POST['fecha_entrada'] ?? '';
$fechaSalida = $_POST['fecha_salida'] ?? '';
$habitacion_id = $_POST['numero_habitacion'] ?? '';

// Verificar que los datos obligatorios están presentes
if (empty($lugar) || empty($fechaEntrada) || empty($fechaSalida) || empty($habitacion_id)) {
    die("Error: faltan parámetros requeridos.");
}

// Comprobar si la habitación ya está reservada en esas fechas
$stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM reservas WHERE numero_habitacion = ? 
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

    $stmt->execute([$habitacion_id, $nombre, $apellidos, $email, $telefono, $fechaEntrada, $fechaSalida, $lugar]);

    echo "<h2>Reserva confirmada con éxito.</h2>";
    echo "<p>Habitación: " . htmlspecialchars($habitacion_id) . "</p>";
    echo "<p>Nombre: " . htmlspecialchars($nombre) . "</p>";
    echo "<p>Email: " . htmlspecialchars($email) . "</p>";
    echo "<p>Fecha de Entrada: " . htmlspecialchars($fechaEntrada) . "</p>";
    echo "<p>Fecha de Salida: " . htmlspecialchars($fechaSalida) . "</p>";
    echo "<a href='index.php'>Volver al inicio</a>";
} catch (PDOException $e) {
    die("Error al registrar la reserva: " . $e->getMessage());
}
