<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Resultado</title>
</head>
<body>

<h2>Actualizar Resultado</h2>

<form method="post" action="/update/result">
    <label for="old_username">Usuario Antiguo:</label>
    <input type="text" id="old_username" name="old_username" required>
    <br>
    <label for="new_username">Nuevo Usuario:</label>
    <input type="text" id="new_username" name="new_username" required>
    <br>
    <label for="result_value">Nuevo Resultado:</label>
    <input type="number" id="result_value" name="result_value" required>
    <br>
    <input type="submit" name="submit" value="Actualizar Resultado">
</form>

</body>
</html>

<?php

require dirname(__DIR__, 3) . '/vendor/autoload.php';

use MiW\Results\Adapters\ResultAdapter;
use MiW\Results\Utility\Utils;

// Load environment variables
Utils::loadEnv(dirname(__DIR__, 3));

// Get command line arguments
if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['old_username']) || empty($_POST['new_username']) || empty($_POST['result_value'])) {
        echo 'Missing required fields.';
    } else {

        $oldUsername = $_POST['old_username'];
        $newUsername = $_POST['new_username'];
        $resultValue = (int)$_POST['result_value'];

        $resultAdapter = new ResultAdapter();

        try {
            if ($resultAdapter->updateResult($resultValue, $oldUsername, $newUsername)) {
                echo "Updated user " . $oldUsername . " now: " . $newUsername . " with " . $resultValue . PHP_EOL;
            } else {
                echo "User " . $oldUsername . " not found" . PHP_EOL;
            }

        } catch (Throwable $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
    }
}
?>
