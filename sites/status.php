<?php
session_start();
if (!isset($_SESSION['loggedinst']) || $_SESSION['loggedinst'] !== true) {
    header('Location: login status.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado del Servidor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000;
            color: #fff;
        }
        header {
            background-color: #ff6600;
            padding: 20px;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        nav {
            background-color: #222;
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #ff6600;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        nav a:hover {
            background-color: #cc5200;
        }
        main {
            padding: 20px;
            text-align: center;
        }
        iframe {
            border: none;
            width: 100%;
            height: 80vh;
        }
        footer {
            background-color: #222;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        button {
            background-color: #ff6600;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #cc5200;
        }
    </style>
</head>
<body>
    <header>
        <h1>Estado del Servidor</h1>
    </header>
    <nav>
        <a href="../index.html">Inicio</a>
        <a href="admin.php">Administración</a>
        <a href="descargas.php">Descargas</a>
    </nav>
    <main>
        <p>Monitorización en tiempo real del servidor:</p>
        <form action="logout status.php" method="post"><button type="submit">Cerrar sesion</button></form>
        <iframe src="http://TU_DOMINIO_GRAFANA/d/ID_DASHBOARD?orgId=1&refresh=10s" title="Dashboard de Grafana"></iframe>
            
    </main>
    <footer>
        <p>&copy; 2024 2024 MIPEME/Leogamer644 . Todos los derechos reservados.</p>
    </footer>
</body>
</html>
