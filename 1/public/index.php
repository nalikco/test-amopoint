<?php
define('ROOT_PATH', dirname(__DIR__));

require ROOT_PATH . '/vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Task #1 (.txt uploader)</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<form method="POST" action="upload.php" enctype="multipart/form-data">
    <input type="file"
           accept=".txt"
           required
           name="file">
    <button type="submit">
        Upload
    </button>
</form>
<?php
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $file = $_GET['file'] ?? null;
    if ($status == 'success' && $file) {
        // Instead of '=' you can use any other delimiter
        $fileParser = new \IharKarpliuk\AmoPointFirstTest\FileParser('=');
        $fileResults = $fileParser->parse(ROOT_PATH . '/files/' . $file);

        echo '<div class="status success"></div>';

        // Print file results
        echo "<code><pre>";
        foreach ($fileResults as $result) {
            echo $result['line'] . ' - ' . $result['digits_count'] . PHP_EOL;
        }
        echo "</pre></code>";
    } else {
        echo '<div class="status error"></div>';
    }
}
?>
</body>
</html>
