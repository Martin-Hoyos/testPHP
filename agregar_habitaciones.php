<?php
// agregarHabitacion.php

// Si se envía el formulario (método POST), procesamos la inserción
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Configuración de la conexión a la base de datos
    $host       = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
    $dbname     = "bew3kbjtj9n5faq31kla";
    $dbUsername = "ueaxccosiwgfnuo5";
    $dbPassword = "J9d5wTPIyWsgRyXmEJfd";

    try {
        // Conectar a la base de datos usando PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Recoger y limpiar los datos enviados desde el formulario
        // (Asegúrate de que el formulario tenga los atributos name correctos)
        $numero_habitacion  = $_POST['numero_habitacion'] ?? null;  // Puedes optar por autogenerarlo si es necesario
        $nombre_habitacion  = trim($_POST['nombre_habitacion'] ?? '');
        $numero_personas    = trim($_POST['numero_personas'] ?? '');
        $descripcion        = trim($_POST['descripcion'] ?? '');
        $precio_noche       = trim($_POST['precio_noche'] ?? '');
        $lugar              = trim($_POST['lugar'] ?? '');
        $fotos              = trim($_POST['fotos'] ?? '');

        // Validar campos obligatorios (por ejemplo: nombre, número de personas, precio, lugar)
        if (empty($nombre_habitacion) || empty($numero_personas) || empty($precio_noche) || empty($lugar)) {
            $mensaje = "<p style='color:red;'>Por favor, complete los campos obligatorios.</p>";
        } else {
            // Preparar la consulta SQL para insertar la habitación.
            // Si numero_habitacion es autogenerado (por ejemplo, AUTO_INCREMENT) podrías omitirlo.
            $sql = "INSERT INTO Habitaciones (numero_habitacion, nombre_habitacion, numero_personas, descripcion, precio_noche, lugar, fotos)
                    VALUES (:numero_habitacion, :nombre_habitacion, :numero_personas, :descripcion, :precio_noche, :lugar, :fotos)";

            $stmt = $pdo->prepare($sql);

            // Si el número de habitación es opcional o autogenerado, se puede enviar NULL o dejarlo fuera del insert
            // En este ejemplo se asume que se ingresa manualmente.
            $stmt->bindParam(':numero_habitacion', $numero_habitacion, PDO::PARAM_INT);
            $stmt->bindParam(':nombre_habitacion', $nombre_habitacion);
            $stmt->bindParam(':numero_personas', $numero_personas, PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio_noche', $precio_noche);
            $stmt->bindParam(':lugar', $lugar);
            $stmt->bindParam(':fotos', $fotos);

            if ($stmt->execute()) {
                $mensaje = "<p style='color:green;'>Habitación agregada exitosamente.</p>";
            } else {
                $mensaje = "<p style='color:red;'>Error al agregar la habitación.</p>";
            }
        }
    } catch (PDOException $e) {
        $mensaje = "<p style='color:red;'>Error de conexión: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Habitación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="url"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #45a049;
        }
        .mensaje {
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Agregar Habitación</h2>
    <div class="mensaje">
        <?php
        if (isset($mensaje)) {
            echo $mensaje;
        }
        ?>
    </div>
    <form action="agregarHabitacion.php" method="post">
        <label for="numero_habitacion">Número de Habitación</label>
        <input type="number" name="numero_habitacion" id="numero_habitacion" placeholder="Ingrese el número (opcional o requerido según tu BD)">

        <label for="nombre_habitacion">Nombre de la Habitación</label>
        <input type="text" name="nombre_habitacion" id="nombre_habitacion" placeholder="Ingrese el nombre" required>

        <label for="numero_personas">Número de Personas</label>
        <input type="number" name="numero_personas" id="numero_personas" placeholder="Ingrese la capacidad" required>

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="4" placeholder="Ingrese una descripción"></textarea>

        <label for="precio_noche">Precio por Noche</label>
        <input type="number" step="0.01" name="precio_noche" id="precio_noche" placeholder="Ingrese el precio" required>

        <label for="lugar">Lugar</label>
        <input type="text" name="lugar" id="lugar" placeholder="Ingrese la ubicación" required>

        <label for="fotos">URL de la Foto</label>
        <input type="url" name="fotos" id="fotos" placeholder="Ingrese la URL de la foto">

        <button type="submit">Agregar Habitación</button>
    </form>
</div>
</body>
</html>
