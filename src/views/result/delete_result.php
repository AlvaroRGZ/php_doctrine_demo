<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Resultado</title>
</head>
<body>

<h2>Eliminar Resultado</h2>

<form method="post" action="/delete/result">
    <label for="result_id">ID del Resultado:</label>
    <input type="number" id="result_id" name="result_id" required>
    <br>
    <input type="submit" name="submit" value="Eliminar Resultado">
</form>

</body>
</html>

<?php

require dirname(__DIR__, 3) . '/vendor/autoload.php';

use MiW\Results\Adapters\ResultAdapter;
use MiW\Results\Utility\DoctrineConnector;
use MiW\Results\Utility\Utils;

// Load environment variables
Utils::loadEnv(dirname(__DIR__, 3));

// Get command line arguments
if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['result_id'])) {
        echo 'Missing required fields.';
    } else {

        $resultId = (int)$_POST['result_id'];

        $entityManager = DoctrineConnector::getEntityManager();
        $resultAdapter = new ResultAdapter();

        try {
            if ($resultAdapter->deleteResultById($resultId)) {
                echo "Deleted result with ID: " . $resultId . PHP_EOL;
            } else {
                echo "Result with ID " . $resultId . " not found" . PHP_EOL;
            }

        } catch (Throwable $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
    }
}
?>
