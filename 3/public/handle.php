<?php
// show all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use IharKarpliuk\AmoPointThirdTest\Location;
use IharKarpliuk\AmoPointThirdTest\Storage;
use WhichBrowser\Parser;

define('ROOT_PATH', dirname(__DIR__));
require ROOT_PATH . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $storage = new Storage(ROOT_PATH . '/storage/app.db');
    $storage->createTableIfNotExist();

    $ip = Location::getIp();
    $city = Location::getCity($ip);
    $device = new Parser(getallheaders());

    $storage->save($ip, $city, $device->toString());

    echo json_encode(['status' => 'ok']);
}
