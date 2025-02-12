<?php
session_start();

// Credenciales de la base de datos
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $numero_habitacion = $_POST['numero_habitacion'] ?? null;
    $nombre_cliente = $_POST['nombre_cliente'] ?? null;
    $apellidos_cliente = $_POST['apellidos_cliente'] ?? null;
    $email = $_POST['email'] ?? null;
    $numero_telefono = $_POST['numero_telefono'] ?? null;
    $fecha_entrada = $_POST['fecha_entrada'] ?? null;
    $fecha_salida = $_POST['fecha_salida'] ?? null;
    $lugar = $_POST['lugar'] ?? null;

    // Validar datos obligatorios
    if (!$numero_habitacion || !$nombre_cliente || !$apellidos_cliente || !$email || !$numero_telefono || !$fecha_entrada || !$fecha_salida || !$lugar) {
        header("Location: Reservar.php?error=Faltan datos");
        exit();
    }

    // Validar fechas
    if ($fecha_entrada >= $fecha_salida) {
        header("Location: Reservar.php?error=Fechas inválidas");
        exit();
    }

    try {
        $sql = "INSERT INTO reservas (numero_habitacion, nombre_cliente, apellidos_cliente, email, numero_telefono, fecha_entrada, fecha_salida, lugar)
                VALUES (:numero_habitacion, :nombre_cliente, :apellidos_cliente, :email, :numero_telefono, :fecha_entrada, :fecha_salida, :lugar)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':numero_habitacion' => $numero_habitacion,
            ':nombre_cliente' => $nombre_cliente,
            ':apellidos_cliente' => $apellidos_cliente,
            ':email' => $email,
            ':numero_telefono' => $numero_telefono,
            ':fecha_entrada' => $fecha_entrada,
            ':fecha_salida' => $fecha_salida,
            ':lugar' => $lugar
        ]);

        header("Location: Reservar.php?success=1");
        exit();
    } catch (PDOException $e) {
        header("Location: Reservar.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}
?>
