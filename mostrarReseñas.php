<?php
$servername = "localhost"; // Cambia según tu servidor
$username = "root"; // Usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$database = "tu_base_de_datos"; // Nombre de la base de datos

// Conectar a MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener las reseñas
$sql = "SELECT Nombre, Puntuacion, Comentario FROM reseñas ORDER BY Puntuacion DESC";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    echo "<div class='reseñas'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='reseña'>";
        echo "<h3>" . htmlspecialchars($row["Nombre"]) . "</h3>";
        echo "<p>Puntuación: " . htmlspecialchars($row["Puntuacion"]) . " ⭐</p>";
        echo "<p>" . htmlspecialchars($row["Comentario"]) . "</p>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p>No hay reseñas aún.</p>";
}

// Cerrar conexión
$conn->close();
?>
