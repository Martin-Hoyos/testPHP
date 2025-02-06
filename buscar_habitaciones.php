<?php
$host = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
$dbname = "bew3kbjtj9n5faq31kla";
$username = "ueaxccosiwgfnuo5";
$password = "J9d5wTPIyWsgRyXmEJfd";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $lugar = isset($_GET['lugar']) ? $_GET['lugar'] : null;
        $fechaEntrada = isset($_GET['fechaEntrada']) ? $_GET['fechaEntrada'] : null;
        $fechaSalida = isset($_GET['fechaSalida']) ? $_GET['fechaSalida'] : null;

        if (empty($lugar) || empty($fechaEntrada) || empty($fechaSalida)) {
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

        $habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($habitaciones);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
}

