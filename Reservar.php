<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Reserva de Habitaciones</title>
    <link rel="stylesheet" href="Styles/reserva.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</head>
<body class="bg-gray-100 font-roboto">
<header class="hidden-header">
    <div class="logo">
        <h1><a href="index.php"><img src="Multimedia/logo_BELLAVIST_blanco.png" alt="LogoMenu"></a></h1>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="servicios.html">Servicios</a></li>
            <li><a href="Habitaciones.html">Habitaciones</a></li>
            <li><a href="Contacto.html">Contáctanos</a></li>
            <li>
                <button><span><a href="Reservar.php">Reservar</a></span></button>
            </li>
        </ul>
    </nav>
</header>
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold text-gray-700 text-center">Reserva de Habitaciones</h2>
    <form id="buscarHabitaciones" class="mt-4">
        <select name="lugar" id="lugar" required>
            <option value="">Seleccione una Ciudad</option>
            <option value="Lérida">Vall de boí, Lérida</option>
            <option value="Cáceres">Las Hurdes (Cáceres)</option>
            <option value="Cantabria">Valles Pasiegos, Cantabria</option>
        </select>
        <input type="date" name="fechaEntrada" id="fechaEntrada" required>
        <input type="date" name="fechaSalida" id="fechaSalida" required>
        <button type="submit">Ver Disponibilidad</button>
    </form>
    <div id="resultado" class="mt-4"></div>
</div>

<script>
    document.getElementById('buscarHabitaciones').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('buscar_habitaciones.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                let resultado = document.getElementById('resultado');
                resultado.innerHTML = '';

                if (data.error) {
                    resultado.innerHTML = `<p class='text-red-500'>${data.error}</p>`;
                    return;
                }

                if (data.length === 0) {
                    resultado.innerHTML = '<p>No hay habitaciones disponibles.</p>';
                    return;
                }

                data.forEach(habitacion => {
                    resultado.innerHTML += `
            <div class='border p-4 rounded-lg shadow-md mb-4 bg-white'>
                <img src="${habitacion.fotos}" alt="${habitacion.nombre_habitacion}" class='w-full h-40 object-cover rounded-md'>
                <h3 class='text-xl font-bold mt-2'>${habitacion.nombre_habitacion}</h3>
                <p><strong>Personas:</strong> ${habitacion.numero_personas}</p>
                <p><strong>Descripción:</strong> ${habitacion.descripcion}</p>
                <p><strong>Precio:</strong> ${habitacion.precio_noche}€ por noche</p>
                <form action="confirmar_reserva.php" method="POST">
                    <input type="hidden" name="numero_habitacion" value="${habitacion.id}">
                <input type="hidden" name="lugar" value="${habitacion.lugar}">
                <input type="hidden" name="fecha_entrada" value="${document.getElementById('fechaEntrada').value}">
                <input type="hidden" name="fecha_salida" value="${document.getElementById('fechaSalida').value}">
                    <button type="submit" class="block bg-black text-white text-center py-2 px-4 rounded mt-3">Reservar</button>
                </form>
            </div>`;
                });
            })
            .catch(error => console.error('Error:', error));
    });


</script>
</body>
</html>
