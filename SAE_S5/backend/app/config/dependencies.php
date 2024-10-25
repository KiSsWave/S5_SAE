<?php

use nrv\application\action\CreerCommandeAction;
use nrv\application\action\GetCommandeAction;
use nrv\application\action\GetPanierAction;
use nrv\application\action\GetSoireeByIDAction;
use nrv\application\action\CreateBilletAction;
use Psr\Container\ContainerInterface;
use nrv\core\services\Soiree\SoireeServiceInterface;
use nrv\infrastructure\repositories\SoireeRepository;
use nrv\core\services\Soiree\SoireeService;
use nrv\core\repositoryInterfaces\SoireeRepositoryInterface;
use nrv\core\services\Spectacle\SpectacleServiceInterface;
use nrv\infrastructure\repositories\SpectacleRepository;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;
use nrv\application\action\GetSpectaclesAction;
use nrv\core\services\Spectacle\SpectacleService;
use nrv\application\action\SignInAction;
use nrv\core\services\auth\AuthnServiceInterface;
use nrv\core\repositoryInterfaces\UserRepositoryInterface;
use nrv\infrastructure\repositories\UserRepository;
use nrv\core\services\auth\AuthnService;
use nrv\application\providers\AuthnProviderInterface;
use nrv\application\providers\JWTAuthnProvider;
use nrv\application\providers\JWTManager;
use nrv\application\action\RegisterAction;
use nrv\application\middleware\AuthnMiddleware;
use nrv\application\middleware\AuthzOrganisateurMiddleware;
use nrv\application\middleware\AuthzUserMiddleware;
use nrv\core\services\auth\AuthzServiceInterface;
use nrv\core\services\auth\AuthzService;
use nrv\application\action\CreerPanierAction;
use nrv\application\action\CreateSpectacleAction;
return[

    SoireeRepositoryInterface::class => function (){
        return new SoireeRepository();
    },

    SpectacleRepositoryInterface::class => function (){
        return new SpectacleRepository();
    },

    UserRepositoryInterface::class => function(){
        return new UserRepository();
    },

    SoireeServiceInterface::class => function (ContainerInterface $c){
        return new SoireeService($c->get(SoireeRepositoryInterface::class));
    },

    SpectacleServiceInterface::class => function (ContainerInterface $c){
        return new SpectacleService($c->get(SpectacleRepositoryInterface::class));
    },

    AuthnServiceInterface::class => function (ContainerInterface $c){
        return new AuthnService($c->get(UserRepositoryInterface::class));
    },

    AuthnProviderInterface::class =>function (ContainerInterface $c){
        return new JWTAuthnProvider($c->get(JWTManager::class), $c->get(AuthnServiceInterface::class));
    },

    AuthzServiceInterface::class => function (ContainerInterface $c) {
        return new AuthzService($c->get(JWTManager::class));
    },

    AuthnMiddleware::class =>function (ContainerInterface $c){
        return new AuthnMiddleware($c->get(AuthnProviderInterface::class));
    },

    AuthzUserMiddleware::class =>function (ContainerInterface $c){
        return new AuthzUserMiddleware($c->get(AuthzServiceInterface::class));
    },

    AuthzOrganisateurMiddleware::class =>function (ContainerInterface $c){
        return new AuthzOrganisateurMiddleware($c->get(AuthzServiceInterface::class));
    },

    GetSoireeByIDAction::class => function (ContainerInterface $c){
        return new GetSoireeByIDAction($c->get(SoireeServiceInterface::class));
    },

    GetSpectaclesAction::class => function (ContainerInterface $c){
        return new GetSpectaclesAction($c->get(SpectacleServiceInterface::class));
    },

    CreateBilletAction::class => function (ContainerInterface $c){
        return new CreateBilletAction($c->get(SoireeServiceInterface::class));
    },

    SignInAction::class => function (ContainerInterface $c){
        return new SignInAction($c->get(AuthnProviderInterface::class));
    },

    RegisterAction::class => function (ContainerInterface $c){
        return new RegisterAction($c->get(AuthnProviderInterface::class));
    },

    CreerPanierAction::class => function(ContainerInterface $c){
        return new CreerPanierAction($c->get(SoireeServiceInterface::class));
    },


    CreateSpectacleAction::class => function (ContainerInterface $c){
        return new CreateSpectacleAction($c->get(SpectacleServiceInterface::class));
    },

    GetPanierAction::class => function(ContainerInterface $c){
        return new GetPanierAction($c->get(SoireeServiceInterface::class));

    },

    CreerCommandeAction::class => function(ContainerInterface $c){
        return new CreerCommandeAction($c->get(SoireeServiceInterface::class));
    },

    GetCommandeAction::class => function(ContainerInterface $c){
        return new GetCommandeAction($c->get(SoireeServiceInterface::class));
    }

];