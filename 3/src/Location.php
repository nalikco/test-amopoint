<?php

namespace IharKarpliuk\AmoPointThirdTest;

class Location
{
    /**
     * Retrieves the IP address of the client.
     *
     * This function checks the $_SERVER super-global array for the presence of specific headers
     * that may contain the client's IP address. It first checks for the 'HTTP_CLIENT_IP' header,
     * which is commonly used for load balanced setups. If that header is not present, it checks
     * for the 'HTTP_X_FORWARDED_FOR' header, which may be used when the client is behind a proxy.
     * If neither of these headers is present, it falls back to the 'REMOTE_ADDR' header, which
     * contains the IP address of the client directly connecting to the server.
     *
     * @return string The IP address of the client.
     */
    public static function getIp(): string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Retrieves the city associated with the given IP address.
     *
     * @param string $ip The IP address to lookup.
     * @return string The city associated with the IP address, or 'Unknown' if not found.
     */
    public static function getCity(string $ip): string
    {
        $response = Request::send("http://ip-api.com/json/$ip");
        $result = json_decode($response, true);

        return $result['city'] ?? 'Unknown';
    }
}