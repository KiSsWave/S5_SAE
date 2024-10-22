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

return[

    SoireeRepositoryInterface::class => function (){
        return new SoireeRepository();
    },

    SpectacleRepositoryInterface::class => function (){
        return new SpectacleRepository();
    },
    SoireeServiceInterface::class => function (ContainerInterface $c){
        return new SoireeService($c->get(SoireeRepositoryInterface::class));
    },

    SpectacleServiceInterface::class => function (ContainerInterface $c){
        return new SpectacleService($c->get(SpectacleRepositoryInterface::class));
    },

    GetSoireeByIDAction::class => function (ContainerInterface $c){
        return new GetSoireeByIDAction($c->get(SoireeServiceInterface::class));
    },

    GetSpectaclesAction::class => function (ContainerInterface $c){
        return new GetSpectaclesAction($c->get(SpectacleServiceInterface::class));
    }

];