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
        (numero_habitacion, nombre_cliente, email, fecha_entrada, fecha_salida, lugar) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param("isssss",
    $numero_habitacion,
    $nombre_cliente,
    $email_cliente,
    $fecha_entrada,
    $fecha_salida,
    $lugar
);


if ($stmt->execute()) {
    echo "<div style='background-color: #000; color: #fff; padding: 20px; border-radius: 8px; margin: 20px auto; max-width: 600px; font-family: Arial, sans-serif;'>";
    echo "<h2 style='text-align: center; border-bottom: 1px solid #fff; padding-bottom: 10px;'>Reserva confirmada con éxito.</h2>";
    echo "<p><strong>Habitación:</strong> " . htmlspecialchars($numero_habitacion) . "</p>";
    echo "<p><strong>Nombre:</strong> " . htmlspecialchars($nombre_cliente) . "</p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($email_cliente) . "</p>";
    echo "<p><strong>Fecha de Entrada:</strong> " . htmlspecialchars($fecha_entrada) . "</p>";
    echo "<p><strong>Fecha de Salida:</strong> " . htmlspecialchars($fecha_salida) . "</p>";
    echo "<p><strong>Lugar:</strong> " . htmlspecialchars($lugar) . "</p>";
    echo "<div style='text-align: center; margin-top: 20px;'>";
    echo "<a href='index.php' style='color: #fff; text-decoration: none; border: 1px solid #fff; padding: 10px 20px; border-radius: 4px;'>Volver al inicio</a>";
    echo "</div>";
    echo "</div>";
} else {
    echo "<div style='background-color: #000; color: #fff; padding: 20px; border-radius: 8px; margin: 20px auto; max-width: 600px; font-family: Arial, sans-serif;'>";
    echo "<h2 style='text-align: center; border-bottom: 1px solid #fff; padding-bottom: 10px;'>Error al registrar la reserva:</h2>";
    echo "<p>" . $stmt->error . "</p>";
    echo "</div>";
}


$stmt->close();
$conn->close();
