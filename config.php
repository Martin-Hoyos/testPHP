<?php
session_start();

define("DB_SERVER", "bew3kbjtj9n5faq31kla-mysql.services.clever-cloud.com");
define("DB_USERNAME", "ueaxccosiwgfnuo5");
define("DB_PASSWORD", "J9d5wTPIyWsgRyXmEJfd");
define("DB_NAME", "bew3kbjtj9n5faq31kla");

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
