<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Configuración del body para centrar el contenido */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        /* Contenedor principal */
        .container {
            text-align: center;
            padding: 2rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        /* Contenedor de los botones */
        .button-container {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        /* Estilos para los botones */
        .button-container button {
            padding: 1rem 2rem;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            background-color: #3d405b;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button-container button:hover {
            background-color: #2d2f3a;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido, en este panel encotraras las bases de datos y cambiarlas a tu conveniencia; ?></h1>
        <div class="button-container">
            <button onclick="location.href='dashboard.php'">Habitaciones</button>
            <button onclick="location.href='profile.php'">Usuarios</button>
            <button onclick="location.href='settings.php'">Reseñas</button>
            <button onclick="location.href='Logout.php'">Cerrar Sesión</button>
        </div>
    </div>

</body>
</html>