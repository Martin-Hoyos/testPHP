<?php
session_start();


if (!isset($_SESSION['usuario'])) {
    echo "<script>
        alert('ERROR: No has iniciado sesión.');
        window.location.href = 'Login.html';
    </script>";
    exit;
}


$servername   = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
$usernameDB   = "ueaxccosiwgfnuo5";
$passwordDB   = "J9d5wTPIyWsgRyXmEJfd";
$dbname       = "bew3kbjtj9n5faq31kla";


$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Recibir datos enviados desde el formulario
$numero_habitacion = $_POST['numero_habitacion'] ?? '';
$lugar             = $_POST['lugar'] ?? '';
$fecha_entrada     = $_POST['fecha_entrada'] ?? '';
$fecha_salida      = $_POST['fecha_salida'] ?? '';


if (empty($numero_habitacion)) {
    die("Error: El número de habitación es requerido.");
}


$checkSQL = "SELECT COUNT(*) as count FROM Habitaciones WHERE numero_habitacion = ?";
$stmtCheck = $conn->prepare($checkSQL);
$stmtCheck->bind_param("i", $numero_habitacion);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();
$rowCheck = $resultCheck->fetch_assoc();
if ($rowCheck['count'] == 0) {
    die("Error: La habitación no existe en el registro.");
}
$stmtCheck->close();

// Obtener datos del usuario de la sesión
$nombre_cliente = $_SESSION['nombre'];
$email_cliente  = $_SESSION['usuario'];
$numero_telefono = '';


$sql = "INSERT INTO Reservadas 
        (numero_habitacion, nombre_cliente, email, numero_telefono, fecha_entrada, fecha_salida, lugar) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param("issssss",
    $numero_habitacion,
    $nombre_cliente,
    $email_cliente,
    $numero_telefono,
    $fecha_entrada,
    $fecha_salida,
    $lugar
);


if ($stmt->execute()) {
    echo "<h2>Reserva confirmada con éxito.</h2>";
    echo "<p>Habitación: " . htmlspecialchars($numero_habitacion) . "</p>";
    echo "<p>Nombre: " . htmlspecialchars($nombre_cliente) . "</p>";
    echo "<p>Email: " . htmlspecialchars($email_cliente) . "</p>";
    echo "<p>Fecha de Entrada: " . htmlspecialchars($fecha_entrada) . "</p>";
    echo "<p>Fecha de Salida: " . htmlspecialchars($fecha_salida) . "</p>";
    echo "<p>Lugar: " . htmlspecialchars($lugar) . "</p>";
    echo "<a href='index.php'>Volver al inicio</a>";
} else {
    echo "Error al registrar la reserva: " . $stmt->error;
}


$stmt->close();
$conn->close();
