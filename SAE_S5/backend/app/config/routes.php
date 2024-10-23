<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):\Slim\App {
    $app->get('/soiree/{ID-SOIREE}', nrv\application\action\GetSoireeByIDAction::class);
    $app->get('/spectacles', \nrv\application\action\GetSpectaclesAction::class);

    $app->get('/spectacle/{ID-SPECTACLE}', \nrv\application\action\GetSpectaclebyIdAction::class);

    $app->post('/signin', \nrv\application\action\SignInAction::class);


    $app->options('/{routes:.+}', function (Request $request, Response $response, array $args): Response {
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Max-Age', '3600');
    });

    $app->add(new \nrv\application\middleware\CorsMiddleware());
    return $app;
};