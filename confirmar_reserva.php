<?php
session_start();

// Verificar si el usuario ha iniciado sesión
// (Tu login guarda el correo en $_SESSION['usuario'] y el nombre en $_SESSION['nombre'])
if (!isset($_SESSION['usuario'])) {
    die("ERROR: No has iniciado sesión. <a href='Login.html'>Inicia sesión</a>");
}

// Datos de conexión a la base de datos
$servername = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
$usernameDB = "ueaxccosiwgfnuo5";
$passwordDB = "J9d5wTPIyWsgRyXmEJfd";
$dbname = "bew3kbjtj9n5faq31kla";

// Crear conexión
$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Recibir datos del formulario
$numero_habitacion = $_POST['numero_habitacion'] ?? '';
$lugar = $_POST['lugar'] ?? '';
$fecha_entrada = $_POST['fecha_entrada'] ?? '';
$fecha_salida = $_POST['fecha_salida'] ?? '';

// Obtener datos del usuario en sesión
$nombre_cliente = $_SESSION['nombre'];   // Nombre del usuario
$email_cliente = $_SESSION['usuario'];   // Correo del usuario

// Aquí podrías usar un teléfono si lo tuvieras en tu tabla de usuarios
// o simplemente dejarlo vacío o con un valor por defecto:
$numero_telefono = ''; // O "000000000" si lo prefieres

// Preparar la sentencia SQL para insertar en la tabla "reservas"
$sql = "INSERT INTO reservas 
        (numero_habitacion, nombre_cliente, email, numero_telefono, fecha_entrada, fecha_salida, lugar) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issssss",
    $numero_habitacion,
    $nombre_cliente,
    $email_cliente,
    $numero_telefono,
    $fecha_entrada,
    $fecha_salida,
    $lugar
);

// Ejecutar la inserción
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

// Cerrar conexiones
$stmt->close();
$conn->close();
?>
