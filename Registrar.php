<?php

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

$nombre     = trim($_POST['nombre'] ?? '');
$email      = trim($_POST['email'] ?? '');
$telefono   = trim($_POST['telefono'] ?? '');
$contrasenia = trim($_POST['password'] ?? '');

if (empty($nombre) || empty($email) || empty($contrasenia)) {
    header("Location: Login.html?error=missing_fields");
    exit;
}

// Verificar si el correo ya existe en la tabla 'usuario'
$checkEmailSql = "SELECT * FROM usuario WHERE email = ?";
$checkStmt = $pdo->prepare($checkEmailSql);
$checkStmt->execute([$email]);

if ($checkStmt->rowCount() > 0) {

    header("Location: registrar.php?error=email_exists");
    exit;
}

$insertSql = "INSERT INTO usuario (id_u, nombre, email, contrasenia, telefono) 
              VALUES (FLOOR(1000 + RAND() * 9000), ?, ?, ?, ?)";
$insertStmt = $pdo->prepare($insertSql);
$insertStmt->execute([$nombre, $email, $contrasenia, $telefono]);

if ($insertStmt->rowCount() > 0) {

    header("Location: Login.html");
    exit;
} else {

    header("Location: Login.html?error=registration_failed");
    exit;
}
