<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):\Slim\App {
    $app->get('/soiree/{ID-SOIREE}', nrv\application\action\GetSoireeByIDAction::class);

    $app->options('/{routes:.+}',
        function( Request $rq,
                  Response $rs, array $args) : Response {
            return $rs;
        })->add(new \nrv\application\middleware\CorsMiddleware());

    return $app;
};