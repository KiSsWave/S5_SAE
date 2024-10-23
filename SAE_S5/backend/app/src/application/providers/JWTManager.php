<?php

namespace nrv\application\providers;

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTManager
{
    private $jwtSecret;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../config', 'token.env');
        $dotenv->load();

        $this->jwtSecret = $_ENV['JWT_SECRET'];
    }

    public function createAccessToken(array $payload): string
    {
        return JWT::encode($payload, $this->jwtSecret, 'HS256');
    }

    public function decodeToken(string $token): array
    {
        return (array)JWT::decode($token, new Key($this->jwtSecret, 'HS256'));
    }
}