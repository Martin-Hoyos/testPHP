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
    $correo = $_POST['correo'];
    $contrasenia = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM Administrador WHERE correo = ? AND contrasenia = ?");
    $stmt->bind_param("ss", $correo, $contrasenia);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se obtiene la información del usuario
        $row = $result->fetch_assoc();
        $_SESSION['usuario'] = $correo;
        $_SESSION['nombre'] = $row['nombre'];
        header("Location: Menu_admin.php"); // Redirige a la página principal (asegúrate de que la extensión sea .php)
        exit();
    } else {
        echo "<script>alert('Por favor dejar de intentar si no tiene cuenta administrador.'); window.location.href='admin_login.html';</script>";
    }
    $stmt->close();
}

$conn->close();
