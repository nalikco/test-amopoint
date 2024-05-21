<?php

namespace IharKarpliuk\AmoPointThirdTest;

use JetBrains\PhpStorm\NoReturn;

class Request
{
    /**
     * Sends a GET request to the specified URL using cURL and returns the response.
     *
     * @param string $url The URL to send the request to.
     * @return string The response from the server.
     */
    public static function send(string $url): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * Redirects the user to the specified URL.
     *
     * @param string $url The URL to redirect to.
     */
    #[NoReturn] public static function redirect(string $url, array $query = []): void
    {
        $queryString = '';
        if (!empty($query)) {
            $queryString = '?' . http_build_query($query);
        }

        $url = $url . $queryString;
        header("Location: $url");
        exit;
    }
}