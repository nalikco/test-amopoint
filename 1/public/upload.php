<?php
define('ROOT_PATH', dirname(__DIR__));

require ROOT_PATH . '/vendor/autoload.php';

use IharKarpliuk\AmoPointFirstTest\Exceptions\UploadFileException;
use IharKarpliuk\AmoPointFirstTest\FileUploader;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_FILES['file'])) {
        header('Location: /index.php?' . http_build_query([
                'status' => 'error',
            ]));
        die();
    }

    $responseQuery = [];
    $file = $_FILES['file'];

    $fileUploader = new FileUploader(ROOT_PATH . '/files');

    try {
        $fileName = $fileUploader->upload($file);

        $responseQuery = [
            'status' => 'success',
            'file' => $fileName,
        ];
    } catch (UploadFileException $e) {
        $responseQuery = [
            'status' => 'error',
        ];
    }

    header('Location: /index.php?' . http_build_query($responseQuery));
    die();
}

header('Location: /index.php');
