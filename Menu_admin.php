<?php
// habitaciones.php

// Configuración de la conexión a la base de datos
$host = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
$dbname = "bew3kbjtj9n5faq31kla";
$dbUsername = "ueaxccosiwgfnuo5";
$dbPassword = "J9d5wTPIyWsgRyXmEJfd";

try {
    // Conectar a la base de datos con PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL para obtener todas las habitaciones
    $sql = "SELECT numero_habitacion, nombre_habitacion, numero_personas, descripcion, precio_noche, lugar, fotos FROM Habitaciones";
    $stmt = $pdo->query($sql);
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
    <title>Listado de Habitaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        img {
            width: 100px;
            height: auto;
            border-radius: 5px;
        }
        /* Estilos para los botones del header */
        .header-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 20px;
        }
        .header-buttons button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .header-buttons button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<!-- Sección de botones en la parte superior -->
<div class="header-buttons">
    <button onclick="location.href='agregarHabitacion.php'">Agregar Habitación</button>
    <button onclick="location.href='buscarHabitaciones.php'">Buscar</button>
    <button onclick="location.href='reservas.php'">Ver Reservas</button>
</div>

<h2>Listado de Habitaciones</h2>

<table>
    <thead>
    <tr>
        <th>N° Habitación</th>
        <th>Nombre</th>
        <th>Capacidad</th>
        <th>Descripción</th>
        <th>Precio por Noche</th>
        <th>Ubicación</th>
        <th>Foto</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($habitaciones)): ?>
        <?php foreach ($habitaciones as $habitacion): ?>
            <tr>
                <td><?= htmlspecialchars($habitacion['numero_habitacion']) ?></td>
                <td><?= htmlspecialchars($habitacion['nombre_habitacion']) ?></td>
                <td><?= htmlspecialchars($habitacion['numero_personas']) ?></td>
                <td><?= htmlspecialchars($habitacion['descripcion']) ?></td>
                <td>$<?= number_format($habitacion['precio_noche'], 2) ?></td>
                <td><?= htmlspecialchars($habitacion['lugar']) ?></td>
                <td><img src="<?= htmlspecialchars($habitacion['fotos']) ?>" alt="Foto de la habitación"></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" style="text-align: center;">No hay habitaciones disponibles.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>
