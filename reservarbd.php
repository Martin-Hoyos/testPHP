<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Reserva</title>
    <link rel="stylesheet" href="styles/reserva.css">
</head>
<body>
<h2>Confirmar Reserva</h2>

<?php
if (isset($_GET['success'])) {
    echo "<p class='text-green-500'>Reserva realizada con éxito.</p>";
} elseif (isset($_GET['error'])) {
    echo "<p class='text-red-500'>Error al reservar, inténtalo de nuevo.</p>";
}
?>

<form action="includes/procesar_reserva.php" method="POST">
    <input type="hidden" name="numero_habitacion" value="<?php echo $_GET['id']; ?>">

    <label>Lugar</label>
    <input type="text" name="lugar" value="<?php echo $_GET['lugar']; ?>" readonly>

    <label>Fecha Entrada</label>
    <input type="date" name="fecha_entrada" value="<?php echo $_GET['fechaEntrada']; ?>" readonly>

    <label>Fecha Salida</label>
    <input type="date" name="fecha_salida" value="<?php echo $_GET['fechaSalida']; ?>" readonly>

    <label>Nombre</label>
    <input type="text" name="nombre_cliente" required>

    <label>Apellidos</label>
    <input type="text" name="apellidos_cliente" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Teléfono</label>
    <input type="text" name="numero_telefono" required>

    <button type="submit">Confirmar Reserva</button>
</form>
</body>
</html>
