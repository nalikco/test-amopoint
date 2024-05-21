<?php

namespace IharKarpliuk\AmoPointFirstTest;

use IharKarpliuk\AmoPointFirstTest\Exceptions\UploadFileException;

class FileUploader
{
    private Storage $storage;

    public function __construct(
        private string $filesStoragePath,
    )
    {
        $this->storage = new Storage();
    }

    /**
     * Save uploaded file and return its name.
     *
     * @param array $file Uploaded file.
     * @return string File name.
     * @throws UploadFileException If file was not uploaded.
     */
    public function upload(array $file): string
    {
        $this->createStorageDirectoryIfNotExist();

        $fileExtension = $this->getExtensionFromFileName($file['name']);
        $fileName = $this->generateFileName() . '.' . $fileExtension;
        $fileTempName = $file['tmp_name'];

        $filePath = $this->filesStoragePath . '/' . basename($fileName);
        $this->storage->save($fileTempName, $filePath);

        return $fileName;
    }

    /**
     * Get extension from file name.
     *
     * @param string $fileName File name.
     * @return string File extension.
     */
    private function getExtensionFromFileName(string $fileName): string
    {
        $fileNameParts = explode('.', $fileName);
        return $fileNameParts[count($fileNameParts) - 1];
    }

    /**
     * Generate file name.
     *
     * @return string File name.
     */
    private function generateFileName(): string
    {
        return md5(rand(100000, 999999) . '_' . microtime());
    }

    /**
     * Create storage directory if not exist.
     */
    private function createStorageDirectoryIfNotExist(): void
    {
        if (is_dir($this->filesStoragePath)) return;
        mkdir($this->filesStoragePath, 0777, true);
    }
}
