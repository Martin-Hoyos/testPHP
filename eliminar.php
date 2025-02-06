<?php
// eliminar.php

// Configuración de la base de datos
$host      = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
$dbname    = "bew3kbjtj9n5faq31kla";
$dbUser    = "ueaxccosiwgfnuo5";
$dbPassword = "J9d5wTPIyWsgRyXmEJfd";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // Si se intenta acceder de forma directa, redirige a la página principal (o la que corresponda)
    header("Location: index.php");
    exit;
}

// Validar y obtener el parámetro 'numero_habitacion'
if (!isset($_POST['numero_habitacion']) || !is_numeric($_POST['numero_habitacion'])) {
    // Redirige a 'a.php' con un mensaje de error si el parámetro no es válido
    header("Location: a.php?error=" . urlencode("Los valores ingresados no son válidos."));
    exit;
}

$numeroHabitacion = (int) $_POST['numero_habitacion'];

// Consulta SQL para eliminar la habitación
$sql = "DELETE FROM Habitaciones WHERE numero_habitacion = :numero_habitacion";

try {
    // Conectar a la base de datos usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":numero_habitacion", $numeroHabitacion, PDO::PARAM_INT);
    $stmt->execute();

    $rowsAffected = $stmt->rowCount();

    if ($rowsAffected > 0) {
        // Si se eliminó el registro, redirige a BD.php con un mensaje de éxito
        header("Location: buscar_habitaciones.php?message=" . urlencode("El registro fue eliminado correctamente."));
    } else {
        // Si no se encontró el registro, redirige a BD.php con un mensaje de error
        header("Location: buscar_habitaciones.php?error=" . urlencode("No se encontró el registro con el número de habitación especificado."));
    }
    exit;

} catch (PDOException $e) {
    // En caso de error en la base de datos, redirige a b.php con el mensaje de error
    header("Location: b.php?error=" . urlencode("Error al eliminar el registro: " . $e->getMessage()));
    exit;
} catch (Exception $e) {
    // En caso de otro error inesperado, redirige a d.php con el mensaje de error
    header("Location: d.php?error=" . urlencode("Ocurrió un error inesperado: " . $e->getMessage()));
    exit;
}

