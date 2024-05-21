<?php

namespace IharKarpliuk\AmoPointThirdTest;

use IharKarpliuk\AmoPointThirdTest\Exceptions\UnauthenticatedException;

class Authentication
{
    private readonly string $password;
    private const SESSION_KEY = 'auth';

    public function __construct()
    {
        $this->password = md5("12345678");
    }

    /**
     * Authenticates the user by checking if the provided password matches the stored password.
     *
     * @param string $password The password to be authenticated.
     * @throws UnauthenticatedException If the provided password does not match the stored password.
     */
    public function authenticate(string $password): void
    {
        if (md5($password) != $this->password) {
            throw new UnauthenticatedException();
        }

        $_SESSION[self::SESSION_KEY] = true;
    }

    /**
     * Sign out the user by removing the session key for authentication.
     */
    public function signOut(): void
    {
        unset($_SESSION[self::SESSION_KEY]);
    }

    /**
     * Checks if the user is authenticated.
     *
     * @return bool Returns true if the user is authenticated, false otherwise.
     */
    public function checkAuth(): bool
    {
        return $_SESSION[self::SESSION_KEY] ?? false;
    }
}