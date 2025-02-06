<?php
session_start(); // Iniciar sesión para almacenar datos del usuario
$host = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
$dbname = "bew3kbjtj9n5faq31kla";
$username = "ueaxccosiwgfnuo5";
$password = "J9d5wTPIyWsgRyXmEJfd";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["error" => "Error de conexión: " . $e->getMessage()]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lugar = $_POST['lugar'] ?? null;
    $fechaEntrada = $_POST['fechaEntrada'] ?? null;
    $fechaSalida = $_POST['fechaSalida'] ?? null;

    // Guardar los datos del usuario en sesión para no pedirlos dos veces
    $_SESSION['nombre_cliente'] = $_POST['nombre_cliente'] ?? '';
    $_SESSION['apellidos_cliente'] = $_POST['apellidos_cliente'] ?? '';
    $_SESSION['email'] = $_POST['email'] ?? '';
    $_SESSION['numero_telefono'] = $_POST['numero_telefono'] ?? '';

    if (!$lugar || !$fechaEntrada || !$fechaSalida) {
        echo json_encode(["error" => "Por favor, ingrese todos los campos."]);
        exit;
    }

    $sql = "SELECT h.numero_habitacion, h.nombre_habitacion, h.numero_personas, h.descripcion, h.precio_noche, h.lugar, h.fotos
            FROM Habitaciones h
            WHERE h.lugar = :lugar 
              AND h.numero_habitacion NOT IN (
                  SELECT r.numero_habitacion
                  FROM Reservadas r
                  WHERE r.lugar = :lugar 
                    AND (
                        (:entrada BETWEEN r.fecha_entrada AND r.fecha_salida) OR
                        (:salida BETWEEN r.fecha_entrada AND r.fecha_salida) OR
                        (r.fecha_entrada BETWEEN :entrada AND :salida)
                    )
              )";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':lugar', $lugar);
    $stmt->bindParam(':entrada', $fechaEntrada);
    $stmt->bindParam(':salida', $fechaSalida);
    $stmt->execute();

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

