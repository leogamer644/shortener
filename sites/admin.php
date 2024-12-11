<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
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
        <h1>Administración</h1>
    </header>
    <nav>
        <a href="../index.html">Inicio</a>
        <a href="status.php">Estado del Servidor</a>
        <a href="descargas.php">descargas</a>
    </nav>
    <main>
        <p>Bienvenido al panel de administración. Desde aquí puedes gestionar las configuraciones del servidor.</p>
        <form action="logout.php" method="post"><button type="submit">Cerrar sesion</button></form>
    </main>
    <footer>
        <p>&copy; 2024 MIPEME/Leogamer644 . Todos los derechos reservados.</p>
    </footer>
</body>
</html>
