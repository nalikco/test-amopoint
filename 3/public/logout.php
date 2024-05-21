<?php
session_start();

use IharKarpliuk\AmoPointThirdTest\Authentication;
use IharKarpliuk\AmoPointThirdTest\Request;

define('ROOT_PATH', dirname(__DIR__));
require ROOT_PATH . '/vendor/autoload.php';

$authentication = new Authentication();
if (!$authentication->checkAuth()) {
    Request::redirect('/login.php');
}

$authentication->signOut();

Request::redirect('/login.php');
