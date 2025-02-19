<?php
$host = "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com";
$dbname = "bew3kbjtj9n5faq31kla";
$username = "ueaxccosiwgfnuo5";
$password = "J9d5wTPIyWsgRyXmEJfd";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT Nombre, Puntuacion, Comentario FROM Resenas ORDER BY Puntuacion DESC";
$result = $conn->query($sql);

echo "<div class='opiniones-recientes'>";
echo "<h2>Reseñas</h2>";

if ($result->num_rows > 0) {
    echo "<div class='contenedor-cards'>";
    while ($row = $result->fetch_assoc()) {
        $puntuacion = (int)$row["Puntuacion"];
        $maxStars = 5;
        $estrellas = "<div class='rating-stars'>";
        for ($i = 1; $i <= $maxStars; $i++) {
            if ($i <= $puntuacion) {
                $estrellas .= "<span class='star'>⭐</span>";
            } else {
                $estrellas .= "<span class='star-off'>☆</span>";
            }
        }
        $estrellas .= "</div>";


        echo "<div class='reseña-card'>";
        echo "<h3>" . htmlspecialchars($row["Nombre"]) . "</h3>";
        echo $estrellas;
        echo "<p class='comentario'>" . htmlspecialchars($row["Comentario"]) . "</p>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p>No hay reseñas aún.</p>";
}

echo "</div>";

$conn->close();

