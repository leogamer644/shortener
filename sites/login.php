<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Credenciales estáticas
    $validUser = 'admin';
    $validPassword = 'asir';

    if ($username === $validUser && $password === $validPassword) {
        $_SESSION['loggedin'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        form {
            display: inline-block;
            background-color: #222;
            padding: 20px;
            border-radius: 5%;
            margin-top: 100px;
        }
        input {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
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
    <h1>Iniciar Sesión</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form action="login.php" method="post">
        <div style="margin-right: 9%; margin-left:1% ">
        <input type="text" name="username" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        </div>
        <a href="../index.html">
        <button type="button">Volver a inicio</button></a>
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>
