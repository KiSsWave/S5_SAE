<?php

namespace nrv\application\middleware;

use Dotenv\Dotenv;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthnMiddleware
{
    private $jwtSecret;


    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../config', 'token.env');
        $dotenv->load();

        $this->jwtSecret = $_ENV['JWT_SECRET'];
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authHeader = $request->getHeaderLine('Authorization');
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return new \Slim\Psr7\Response(401);
        }

        $jwt = $matches[1];

        try {
            $decoded = JWT::decode($jwt, new Key($this->jwtSecret, 'HS256'));
            $request = $request->withAttribute('user_id', $decoded->sub);
            return $handler->handle($request);
        } catch (\Exception $e) {
            return new \Slim\Psr7\Response(401);
        }
    }
}