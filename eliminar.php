<?php
header('Content-Type: application/json');

// Configuración de la base de datos
$host = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
$dbname = "bew3kbjtj9n5faq31kla";
$dbUser = "ueaxccosiwgfnuo5";
$dbPassword = "J9d5wTPIyWsgRyXmEJfd";

// Verificar que la petición sea POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Método no permitido."]);
    exit;
}

// Validar que se reciba 'numero_habitacion' y que sea numérico
if (!isset($_POST['numero_habitacion']) || !is_numeric($_POST['numero_habitacion'])) {
    echo json_encode(["error" => "Los valores ingresados no son válidos."]);
    exit;
}

$numeroHabitacion = (int) $_POST['numero_habitacion'];
$sql = "DELETE FROM Habitaciones WHERE numero_habitacion = :numero_habitacion";

try {
    // Conectar a la base de datos usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":numero_habitacion", $numeroHabitacion, PDO::PARAM_INT);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        echo json_encode(["success" => "El registro fue eliminado correctamente."]);
    } else {
        echo json_encode(["error" => "No se encontró el registro con el número de habitación especificado."]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Error al eliminar el registro: " . $e->getMessage()]);
}
exit;

