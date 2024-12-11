<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descargas</title>
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
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #fff;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #ff6600;
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
    </style>
</head>
<body>
    <header>
        <h1>Descargas</h1>
    </header>
    <nav>
        <a href="../index.html">Inicio</a>
        <a href="admin.php">Administración</a>
        <a href="status.php">Estado del Servidor</a>
    </nav>
    <main>
        <p>A continuación se muestra el directorio de archivos disponibles para descargar:</p>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Archivo</th>
                    <th>Tamaño</th>
                    <th>Descargar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $directory = '../files';
                if (is_dir($directory)) {
                    $files = scandir($directory);
                    foreach ($files as $file) {
                        if ($file !== '.' && $file !== '..') {
                            $filePath = $directory . '/' . $file;
                            $fileSize = filesize($filePath);
                            $fileSizeFormatted = $fileSize >= 1048576 ? round($fileSize / 1048576, 2) . ' MB' : round($fileSize / 1024, 2) . ' KB';
                            echo "<tr>
                                    <td>$file</td>
                                    <td>$fileSizeFormatted</td>
                                    <td><a href='$filePath' download>Descargar</a></td>
                                  </tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='3'>El directorio no existe.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 2024 MIPEME/Leogamer644 . Todos los derechos reservados.</p>
    </footer>
</body>
</html>
