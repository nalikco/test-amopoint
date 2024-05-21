<?php
session_start();

use IharKarpliuk\AmoPointThirdTest\Authentication;
use IharKarpliuk\AmoPointThirdTest\Request;

define('ROOT_PATH', dirname(__DIR__));
require ROOT_PATH . '/vendor/autoload.php';

$authentication = new Authentication();
if ($authentication->checkAuth()) {
    Request::redirect('/results.php');
}

$error = $_GET['error'] ?? '';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
<form action="/login-handler.php" method="POST">
    <label>
        <input type="password"
               placeholder="Enter password"
               required
               autofocus
               name="password">
    </label>
    <button type="submit">Login</button>
</form>
<small style="color: red;font-weight: 500;">
    <?=$error?>
</small>
</body>
</html>
