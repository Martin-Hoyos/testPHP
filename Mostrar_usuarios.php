<?php



$host = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
$dbname = "bew3kbjtj9n5faq31kla";
$dbUsername = "ueaxccosiwgfnuo5";
$dbPassword = "J9d5wTPIyWsgRyXmEJfd";

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = "SELECT email, nombre, id_u FROM usuario";
    $stmt = $pdo->query($sql);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        /* Estilo para el botón de eliminar en cada fila */
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<h2>Control de usarios</h2>

<table>
    <thead>
    <tr>
        <th>ID de Usuario</th>
        <th>Email de usario</th>
        <th>Nombre de usario</th>

    </tr>
    </thead>
    <tbody>
    <?php if (!empty($usuarios)): ?>
        <?php foreach ($usuarios as $usuarios): ?>
            <tr id="row-<?= htmlspecialchars($usuarios['id_u']) ?>">
                <td><?= htmlspecialchars($usuarios['email']) ?></td>
                <td><?= htmlspecialchars($usuarios['nombre']) ?></td>
                <td>
                    <!-- Botón de eliminar que llama a la función JavaScript -->
                    <button class="delete-btn" onclick="eliminarUsuario(<?= htmlspecialchars($usuarios['id_u']) ?>, this)">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8" style="text-align: center;">No hay habitaciones disponibles.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<script>
    function eliminarUsuario(nombre, btn) {
        if (confirm("¿Está seguro que desea eliminar el usario " + nombre + "?")) {
            // Preparar los datos para enviar por POST
            var formData = new FormData();
            formData.append("id_u", nombre);

            // Enviar la petición AJAX a eliminar_ajax.php
            fetch("eliminarUsario.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert(data.success);
                        // Eliminar la fila de la tabla sin recargar la página
                        var row = btn.parentNode.parentNode;
                        row.parentNode.removeChild(row);
                    } else if(data.error) {
                        alert(data.error);
                    } else {
                        alert("Error desconocido.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Ocurrió un error al intentar eliminar al usario.");
                });
        }
    }
</script>