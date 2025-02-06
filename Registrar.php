<?php
// Registrar.php

// Configuración de la conexión a la base de datos
$host = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
$dbname = "bew3kbjtj9n5faq31kla";
$dbUsername = "ueaxccosiwgfnuo5";
$dbPassword = "J9d5wTPIyWsgRyXmEJfd";

try {
    // Conexión con PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Recuperar los datos del formulario
// Asegúrate de que el formulario tenga estos atributos name:
// nombre, email, telefono, password
$nombre     = trim($_POST['nombre'] ?? '');
$email      = trim($_POST['email'] ?? '');
$telefono   = trim($_POST['telefono'] ?? '');
$contrasenia = trim($_POST['password'] ?? '');

// Validar que los campos obligatorios no estén vacíos
if (empty($nombre) || empty($email) || empty($contrasenia)) {
    // Si falta algún dato, redirecciona de nuevo a la página de registro (por ejemplo, registrar.php) con un mensaje de error
    header("Location: registrar.php?error=missing_fields");
    exit;
}

// Verificar si el correo ya existe en la tabla 'usuario'
$checkEmailSql = "SELECT * FROM usuario WHERE email = ?";
$checkStmt = $pdo->prepare($checkEmailSql);
$checkStmt->execute([$email]);

if ($checkStmt->rowCount() > 0) {
    // Si el correo ya está registrado, redirecciona a la página de registro con un mensaje de error
    header("Location: registrar.php?error=email_exists");
    exit;
}

// Insertar el nuevo usuario
// En el ejemplo Java se usaba:
// FLOOR(1000 + RAND() * 9000) para generar un id aleatorio.
// Asegúrate de que la columna id_u en la tabla 'usuario' acepte este tipo de valor.
$insertSql = "INSERT INTO usuario (id_u, nombre, email, contrasenia, telefono) 
              VALUES (FLOOR(1000 + RAND() * 9000), ?, ?, ?, ?)";
$insertStmt = $pdo->prepare($insertSql);
$insertStmt->execute([$nombre, $email, $contrasenia, $telefono]);

if ($insertStmt->rowCount() > 0) {
    // Registro exitoso, redirige a la página de inicio de sesión
    header("Location: Login.html");
    exit;
} else {
    // Si no se pudo insertar, redirige a la página de registro con un mensaje de error
    header("Location: Registrar.php?error=registration_failed");
    exit;
}
