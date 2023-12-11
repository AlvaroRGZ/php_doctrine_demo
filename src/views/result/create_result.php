<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear un Resultado</title>
</head>
<body>

<h2>Crear un Resultado</h2>

<form method="post" action="/create/result">
    <label for="username">Nombre de Usuario:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="result">Resultado:</label>
    <input type="text" id="result" name="result" required>
    <br>
    <input type="submit" name="submit" value="Crear Resultado">
</form>

</body>
</html>
<?php

require dirname(__DIR__, 3) . '/vendor/autoload.php';

use MiW\Results\adapters\ResultAdapter;
use MiW\Results\Utility\Utils;

Utils::loadEnv(dirname(__DIR__, 3));

if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['username']) || empty($_POST['result'])) {
        echo 'Missing required fields.';
    } else {
        $username = $_POST['username'];
        $resultValue = $_POST['result'];

        $resultAdapter = new ResultAdapter();

        try {
            if ($resultAdapter->createResultFromScratch((int)$resultValue, $username)) {
                echo 'Created Result: ' . $username . " points: " . $resultValue . PHP_EOL;
            } else {
                echo 'Result not created' . PHP_EOL;
            }

        } catch (Throwable $exception) {
            echo 'Error: ' . $exception->getMessage();
        }
    }
}
?>
