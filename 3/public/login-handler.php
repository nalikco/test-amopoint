<?php
session_start();

use IharKarpliuk\AmoPointThirdTest\Authentication;
use IharKarpliuk\AmoPointThirdTest\Exceptions\UnauthenticatedException;
use IharKarpliuk\AmoPointThirdTest\Request;

define('ROOT_PATH', dirname(__DIR__));
require ROOT_PATH . '/vendor/autoload.php';

$authentication = new Authentication();
if ($authentication->checkAuth()) {
    Request::redirect('/results.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $authentication->authenticate($_POST['password']);
        Request::redirect('/results.php');
    } catch (UnauthenticatedException) {
        Request::redirect('/login.php', [
            'error' => 'Invalid password.',
        ]);
    }
}
