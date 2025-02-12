<?php

$DB_HOST = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
$DB_NAME = "bew3kbjtj9n5faq31kla";
$DB_USER = "ueaxccosiwgfnuo5";
$DB_PASSWORD = "J9d5wTPIyWsgRyXmEJfd";


$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);


if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}


$nombre = $_POST['nombre'];
$correo = $_POST['email'];
$puntuacion = $_POST['puntuacion'];
$comentario = $_POST['comentario'];


$sql_check = "SELECT * FROM Resenas WHERE Correo = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $correo);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {

    echo "<script>alert('Ya tenemos una opinion con su cuenta'); window.location.href='servicios.html';</script>";
} else {

    $sql_insert = "INSERT INTO Resenas (Nombre, Correo, Puntuacion, Comentario) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssss", $nombre, $correo, $puntuacion, $comentario);

    if ($stmt_insert->execute()) {

        echo "<script>alert('Reseña registrada con éxito.'); window.location.href='servicios.html';</script>";
    } else {

        echo "<script>alert('Error: No se pudo registrar la reseña.'); window.location.href='servicios.html';</script>";
    }

    $stmt_insert->close();
}


$stmt_check->close();
$conn->close();
?>
