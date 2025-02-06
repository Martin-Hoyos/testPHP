<?php
session_start();
$servername = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
$username = "ueaxccosiwgfnuo5";
$password = "J9d5wTPIyWsgRyXmEJfd";
$dbname = "bew3kbjtj9n5faq31kla";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['correo'];
    $contrasenia = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ? AND contrasenia = ?");
    $stmt->bind_param("ss", $email, $contrasenia);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se obtiene la información del usuario
        $row = $result->fetch_assoc();
        $_SESSION['usuario'] = $email;
        $_SESSION['nombre'] = $row['nombre']; // Guarda el nombre obtenido de la BD
        header("Location: Index.php"); // Redirige a la página principal (asegúrate de que la extensión sea .php)
        exit();
    } else {
        echo "<script>alert('Correo o contraseña incorrectos.'); window.location.href='Login.html';</script>";
    }
    $stmt->close();
}

$conn->close();
