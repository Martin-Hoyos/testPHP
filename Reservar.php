<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Reserva de Habitaciones</title>
    <link rel="stylesheet" href="Styles/reserva.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap"/>
</head>
<body class="bg-gray-100 font-roboto">
<header class="hidden-header">
    <div class="container mx-auto flex justify-between items-center px-4">
        <div class="logo">
            <a href="index.jsp"><img src="Multimedia/logo_BELLAVIST_blanco.png" alt="LogoMenu"></a>
        </div>
        <nav>
            <ul class="flex space-x-4">
                <li><a href="index.html">Inicio</a></li>
                <li><a href="#">Servicios</a></li>
                <li><a href="#">Habitaciones</a></li>
                <li><a href="../html/contacto.html">Contáctanos</a></li>
                <li><button><span><a href="reservar.jsp">Reservar</a></span></button></li>
            </ul>
        </nav>
    </div>
</header>
<br><br><br><br>
<div class="container mx-auto p-4">
    <div class="habitaciones-container">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-700">Reserva de Habitaciones</h2>
        </div>
        <form class="mt-4" method="get" action="buscar_habitaciones.php">
            <div class="form-row">
                <div class="form-group">
                    <label class="block text-gray-700" for="hotel">Hotel</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md" id="hotel" name="lugar">
                        <option value="">Seleccione una Ciudad</option>
                        <option value="Lérida">Vall de boí, Lérida</option>
                        <option value="Cáceres">Las Hurdes (Cáceres)</option>
                        <option value="Cantabria">Valles Pasiegos, Cantabria</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="block text-gray-700" for="checkin">Fecha de Entrada</label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-md" id="checkin" type="date" name="fechaEntrada"/>
                </div>
                <div class="form-group">
                    <label class="block text-gray-700" for="checkout">Fecha de Salida</label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-md" id="checkout" type="date" name="fechaSalida"/>
                </div>
            </div>
            <div class="text-center mt-4">
                <button class="w-full bg-[#0c1401] text-white py-2 px-4 rounded-md hover:bg-[#0c1401]" type="submit">
                    Ver Disponibilidad
                </button>
            </div>
        </form>

        <!-- Mostrar habitaciones disponibles con PHP -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $lugar = isset($_GET['lugar']) ? $_GET['lugar'] : null;
            $fechaEntrada = isset($_GET['fechaEntrada']) ? $_GET['fechaEntrada'] : null;
            $fechaSalida = isset($_GET['fechaSalida']) ? $_GET['fechaSalida'] : null;

            if ($lugar && $fechaEntrada && $fechaSalida) {
                // Conectar a la base de datos (ajusta con tus datos)
                $conn = new mysqli("localhost", "root", "", "hotel_db");

                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Consulta SQL para obtener habitaciones disponibles
                $sql = "SELECT * FROM habitaciones WHERE lugar = '$lugar' AND disponible = 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<h3 class="font-bold text-lg">Habitaciones disponibles:</h3><ul>';
                    while ($habitacion = $result->fetch_assoc()) {
                        echo '<li class="habitacion-item">';
                        echo '<img src="' . $habitacion['foto'] . '" alt="' . $habitacion['nombre'] . '">';
                        echo '<p><strong>' . $habitacion['nombre'] . '</strong></p>';
                        echo '<p>Personas: ' . $habitacion['num_personas'] . '</p>';
                        echo '<p>Descripción: ' . $habitacion['descripcion'] . '</p>';
                        echo '<p>Precio: ' . $habitacion['precio'] . '€ por noche</p>';
                        echo '<button onclick="mostrarFormulario(' . $habitacion['id'] . ', \'' . $habitacion['nombre'] . '\')">Reservar</button>';
                        echo '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p>No hay habitaciones disponibles para las fechas seleccionadas.</p>';
                }
                $conn->close();
            }
        }
        ?>

        <!-- Formulario de reserva -->
        <div id="formReserva" style="display:none;">
            <h3 class="font-bold text-lg">Formulario de Reserva</h3>
            <form method="POST" action="procesar_reserva.php">
                <input type="hidden" id="numeroHabitacion" name="numeroHabitacion" />
                <input type="hidden" id="nombreHabitacion" name="nombreHabitacion" />

                <div class="form-row">
                    <div class="form-group">
                        <label class="block text-gray-700" for="nombreCliente">Nombre</label>
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md" type="text" id="nombreCliente" name="nombreCliente" required/>
                    </div>
                    <div class="form-group">
                        <label class="block text-gray-700" for="apellidosCliente">Apellidos</label>
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md" type="text" id="apellidosCliente" name="apellidosCliente" required/>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="block text-gray-700" for="email">Email</label>
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md" type="email" id="email" name="email" required/>
                    </div>
                    <div class="form-group">
                        <label class="block text-gray-700" for="telefono">Teléfono</label>
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md" type="tel" id="telefono" name="telefono" required/>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#0c1401] text-white py-2 px-4 rounded-md hover:bg-[#0c1401]">Reservar</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>