<?php

use nrv\application\action\GetSoireeByIDAction;
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

    GetSoireeByIDAction::class => function (ContainerInterface $c){
        return new GetSoireeByIDAction($c->get(SoireeServiceInterface::class));
    },

    GetSpectaclesAction::class => function (ContainerInterface $c){
        return new GetSpectaclesAction($c->get(SpectacleServiceInterface::class));
    },

    SignInAction::class => function (ContainerInterface $c){
        return new SignInAction($c->get(AuthnProviderInterface::class));
    },

    RegisterAction::class => function (ContainerInterface $c){
        return new RegisterAction($c->get(AuthnProviderInterface::class));
    }

];