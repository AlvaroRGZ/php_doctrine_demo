<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
</head>
<body>

<h2>Eliminar Usuario</h2>

<form method="post" action="/delete/user">
    <label for="username">Nombre de Usuario:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <input type="submit" name="submit" value="Eliminar Usuario">
</form>

<?php
use MiW\Results\Adapters\UserAdapter;
use MiW\Results\Utility\DoctrineConnector;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $username = $_POST["username"];

    $entityManager = DoctrineConnector::getEntityManager();
    $userAdapter = new UserAdapter();

    try {
        if ($userAdapter->deleteUser($username)) {
            echo '<h3>Usuario Eliminado:</h3>';
            echo '<p>Usuario ' . $username . ' eliminado correctamente.</p>';
        } else {
            echo '<p>No se pudo eliminar al usuario' . $username . '</p>';
        }

    } catch (Throwable $exception) {
        echo '<p>Error: ' . $exception->getMessage() . '</p>';
    }
}
?>

</body>
</html>
