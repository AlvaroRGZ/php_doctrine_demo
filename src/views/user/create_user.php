<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear un Usuario</title>
</head>
<body>

<h2>Crear un Usuario</h2>

<form method="post" action="/create/user">
    <label for="username">Nombre de Usuario:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <input type="submit" name="submit" value="Crear Usuario">
</form>

<?php

require dirname(__DIR__, 3) . '/vendor/autoload.php';

use MiW\Results\Entity\User;
use MiW\Results\Adapters\UserAdapter;
use MiW\Results\Utility\DoctrineConnector;
use MiW\Results\Utility\Utils;

Utils::loadEnv(dirname(__DIR__, 3));

if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
        echo 'Missing required fields.';
    } else {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $entityManager = DoctrineConnector::getEntityManager();
        $userAdapter = new UserAdapter();

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);

        try {
            if ($userAdapter->createUser($user)) {
                echo 'User' . $username . ' created successfully.' . PHP_EOL;
            } else {
                echo 'Username ' . $username . ' not created' . PHP_EOL;
            }

        } catch (Throwable $exception) {
            echo 'Error: ' . $exception->getMessage();
        }
    }
}
?>

</body>
</html>