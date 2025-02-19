<?php
session_start();

$host = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
$dbname = "bew3kbjtj9n5faq31kla";
$dbUsername = "ueaxccosiwgfnuo5";
$dbPassword = "J9d5wTPIyWsgRyXmEJfd";

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $usuarioEmail = $_SESSION['usuario'];


    $sql = "SELECT numero_habitacion, nombre_cliente, fecha_entrada, fecha_salida, lugar 
            FROM Reservadas 
            WHERE email = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuarioEmail]);


    $habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 50px 100px 0px 100px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f8f8;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #086308;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #2f8000;
        }
    </style>
</head>
<a href="javascript:history.back()" class="back-button">Regresar Atrás</a>
<body>
<h2>Reservas de <?php echo $_SESSION['nombre']; ?></h2>

<table>
    <tr>
        <th>Número de Habitación</th>
        <th>Fecha de Entrada</th>
        <th>Fecha de Salida</th>
        <th>Lugar</th>
    </tr>
    <?php foreach ($habitaciones as $habitacion): ?>
        <tr>
            <td><?php echo htmlspecialchars($habitacion['numero_habitacion']); ?></td>
            <td><?php echo htmlspecialchars($habitacion['fecha_entrada']); ?></td>
            <td><?php echo htmlspecialchars($habitacion['fecha_salida']); ?></td>
            <td><?php echo htmlspecialchars($habitacion['lugar']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>