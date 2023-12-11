<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Data Form</title>
</head>
<body>

    <h2>Read Data</h2>

    <form method="post" action="/read/result">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id">
        <br>
        <input type="submit" name="submit" value="Read Data">
    </form>

</body>
</html>

<?php
require dirname(__DIR__, 3) . '/vendor/autoload.php';

use MiW\Results\adapters\ResultAdapter;
use MiW\Results\Utility\Utils;

// Carga las variables de entorno
Utils::loadEnv(dirname(__DIR__, 3));

if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['id'])) {
        echo 'Missing required fields.';
    } else {

        $resultAdapter = new ResultAdapter();
        $id = $_POST['id'];
        $result = $resultAdapter->readResultById($id);

        if ($result) {
            echo "<h3>Result found</h3>";
            echo json_encode($result->jsonSerialize()) . PHP_EOL;
        } else {
            echo "Result not found" . PHP_EOL;
        }
    }
}
?>