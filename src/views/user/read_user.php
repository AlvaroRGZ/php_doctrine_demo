<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Usuario</title>
</head>
<body>

<h2>Consulta de Usuario</h2>

<form method="post" action="/read/user">
    <label for="username">Nombre de Usuario:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <input type="submit" name="submit" value="Consultar Usuario">
</form>

<?php
use MiW\Results\Adapters\UserAdapter;
use MiW\Results\Utility\DoctrineConnector;

if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    $entityManager = DoctrineConnector::getEntityManager();
    $userAdapter = new UserAdapter();

    try {
        $user = $userAdapter->readUserByUsername($username);

        if ($user) {
            echo '<h3>Usuario Encontrado:</h3>';
            echo '<pre>';
            echo json_encode($user->jsonSerialize(), JSON_PRETTY_PRINT);
            echo '</pre>';
        } else {
            echo '<h3>Usuario no encontrado:</h3>';
            echo '<p>No existe ningun usuario ' . $username . '</p>';
        }
    } catch (Throwable $exception) {
        echo '<p>Error: ' . $exception->getMessage() . '</p>';
    }
}
?>

</body>
</html>