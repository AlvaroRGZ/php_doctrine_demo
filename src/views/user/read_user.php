<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Usuario</title>
</head>
<body>

<h2>Consulta de Usuario</h2>

<form method="post">
    <label for="username">Nombre de Usuario:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <input type="submit" value="Consultar Usuario">
</form>

<?php
use MiW\Results\Adapters\UserAdapter;
use MiW\Results\Utility\DoctrineConnector;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    $entityManager = DoctrineConnector::getEntityManager();
    $userAdapter = new UserAdapter();

    try {
        $user = $userAdapter->readUserByUsername($username);

        echo '<h3>Usuario Encontrado:</h3>';
        if ($user) {
            echo '<pre>';
            echo json_encode($user->jsonSerialize(), JSON_PRETTY_PRINT);
            echo '</pre>';
        } else {
            echo '<p>Usuario ' . $username . ' no encontrado</p>';
        }
    } catch (Throwable $exception) {
        echo '<p>Error: ' . $exception->getMessage() . '</p>';
    }
}
?>

</body>
</html>