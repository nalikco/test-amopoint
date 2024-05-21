<?php

namespace IharKarpliuk\AmoPointFirstTest;

use IharKarpliuk\AmoPointFirstTest\Exceptions\UploadFileException;

class Storage
{
    /**
     * Gets the contents of the file.
     *
     * @param string $filePath The path to the file.
     * @return string The contents of the file.
     */
    public function get(string $filePath): string
    {
        return file_get_contents($filePath);
    }

    /**
     * Saves uploaded file.
     *
     * @param string $fileTempName The temporary name of the uploaded file.
     * @param string $filePath The path where the file should be saved.
     *
     * @throws UploadFileException If the file could not be saved.
     */
    public function save(string $fileTempName, string $filePath): void
    {
        if (!move_uploaded_file($fileTempName, $filePath)) {
            throw new UploadFileException();
        }
    }
}