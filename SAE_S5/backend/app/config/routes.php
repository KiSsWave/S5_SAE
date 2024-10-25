<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):\Slim\App {


    $app->add(new \nrv\application\middleware\CorsMiddleware());

    $app->post('/signin', \nrv\application\action\SignInAction::class);
    $app->post('/register', \nrv\application\action\RegisterAction::class);
    $app->post('/billets', nrv\application\action\CreateBilletAction::class);

    $app->get('/spectacles', \nrv\application\action\GetSpectaclesAction::class);
    $app->get('/spectacle/{ID-SPECTACLE}', \nrv\application\action\GetSpectaclebyIdAction::class);
    $app->get('/soiree/{ID-SOIREE}', nrv\application\action\GetSoireeByIDAction::class);
    $app->get('/lieux', nrv\application\action\GetLieuxAction::class);



    $app->group('', function () use ($app){

        $app->get('/panier', \nrv\application\action\GetPanierAction::class);
        $app->post('/create', \nrv\application\action\CreerPanierAction::class);
        $app->post('/commande', \nrv\application\action\CreerCommandeAction::class);
        $app->get('/commandes', \nrv\application\action\GetCommandeAction::class);



    })->add(\nrv\application\middleware\AuthnMiddleware::class);

    $app->group('', function () use ($app){
        $app->post('/spectacle', \nrv\application\action\CreateSpectacleAction::class);
    })->add(\nrv\application\middleware\AuthnMiddleware::class)
        ->add(\nrv\application\middleware\AuthzOrganisateurMiddleware::class);

    $app->options('/{routes:.+}', function (Request $request, Response $response, array $args): Response {
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Max-Age', '3600');
    });


    return $app;
};