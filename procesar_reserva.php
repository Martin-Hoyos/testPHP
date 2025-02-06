<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_habitacion = $_POST['numero_habitacion'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $apellidos_cliente = $_POST['apellidos_cliente'];
    $email = $_POST['email'];
    $numero_telefono = $_POST['numero_telefono'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $fecha_salida = $_POST['fecha_salida'];
    $lugar = $_POST['lugar'];

    $sql = "INSERT INTO reservas (numero_habitacion, nombre_cliente, apellidos_cliente, email, numero_telefono, fecha_entrada, fecha_salida, lugar)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssss", $numero_habitacion, $nombre_cliente, $apellidos_cliente, $email, $numero_telefono, $fecha_entrada, $fecha_salida, $lugar);

    if ($stmt->execute()) {
        header("Location: reservar.php?success=1");
        exit();
    } else {
        header("Location: reservar.php?error=1");
        exit();
    }
}
?>
