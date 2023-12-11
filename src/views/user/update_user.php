<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>
</head>
<body>

<h2>Actualizar Usuario</h2>

<form method="post" action="/update/user">
    <label for="oldusername">Usuario Antiguo:</label>
    <input type="text" id="oldusername" name="oldusername" required>
    <br>
    <label for="username">Nuevo Nombre de Usuario:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="email">Nuevo Correo Electrónico:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Nueva Contraseña:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <label for="enabled">Habilitado:</label>
    <input type="checkbox" id="enabled" name="enabled" value="1">
    <br>
    <label for="isAdmin">Administrador:</label>
    <input type="checkbox" id="isAdmin" name="isAdmin" value="1">
    <br>
    <input type="submit" name="submit" value="Actualizar Usuario">
</form>

</body>
</html>

<?php
require dirname(__DIR__, 3) . '/vendor/autoload.php';

use MiW\Results\Adapters\UserAdapter;
use MiW\Results\Utility\Utils;

// Load environment variables
Utils::loadEnv(dirname(__DIR__, 3));

$userAdapter = new UserAdapter();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Get form data
    $oldusername = $_POST['oldusername'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $enabled = isset($_POST['enabled']) && $_POST['enabled'] == "1";
    $isAdmin = isset($_POST['isAdmin']) && $_POST['isAdmin'] == "1";

    // Validate form data (add more validation if needed)
    if (empty($oldusername) || empty($username) || empty($email) || empty($password)) {
        echo "Missing required fields.";
    } else {
        try {
            // Perform the update operation
            if ($userAdapter->updateUser($oldusername, $username, $email, $password, $enabled, $isAdmin)) {
                echo "Updated user " . $oldusername . " to: " . $username . PHP_EOL;
            } else {
                echo "User " . $oldusername . " not found" . PHP_EOL;
            }
        } catch (Throwable $exception) {
            echo "Error: " . $exception->getMessage() . PHP_EOL;
        }
    }
}

?>