<?php

namespace nrv\application\middleware;

use nrv\core\services\auth\AuthzServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class AuthzUserMiddleware
{
    private AuthzServiceInterface $authzService;

    public function __construct(AuthzServiceInterface $authzService)
    {
        $this->authzService = $authzService;
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $authHeader = $request->getHeader('Authorization')[0] ?? '';
        $token = str_replace('Bearer ', '', $authHeader);

        if (!$this->authzService->isUser($token)) {
            $response = new Response();
            $response->getBody()->write(json_encode(['error' => 'Access forbidden']));
            return $response->withStatus(403)->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);

    }
}