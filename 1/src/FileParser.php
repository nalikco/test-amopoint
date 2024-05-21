<?php

namespace IharKarpliuk\AmoPointFirstTest;

class FileParser
{
    private Storage $storage;

    public function __construct(
        private string $delimiter,
    )
    {
        $this->storage = new Storage();
    }

    /**
     * Parses .txt file and returns array with parsed data
     *
     * @param string $filePath Path to .txt file
     * @return array The array with parsed data: line, digits_count.
     */
    public function parse(string $filePath): array
    {
        $parsedLines = [];
        $fileContent = $this->storage->get($filePath);
        $sourceLines = explode($this->delimiter, $fileContent);

        foreach ($sourceLines as $line) {
            if (trim($line) == '') continue;
            $parsedLines[] = $this->parseLine($line);
        }

        return $parsedLines;
    }

    /**
     * Parses single line and returns array with parsed data
     *
     * @param string $line Single line
     * @return array The array with parsed data: line, digits_count.
     */
    private function parseLine(string $line): array
    {
        return [
            'line' => $line,
            'digits_count' => preg_match_all('/\d/', $line),
        ];
    }
}