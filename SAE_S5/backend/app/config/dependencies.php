<?php

use nrv\application\action\GetSoireeByIDAction;
use Psr\Container\ContainerInterface;
use nrv\core\services\Soiree\SoireeServiceInterface;
use nrv\infrastructure\repositories\SoireeRepository;
use nrv\core\services\Soiree\SoireeService;
use nrv\core\repositoryInterfaces\SoireeRepositoryInterface;

return[

    SoireeRepositoryInterface::class => function (ContainerInterface $c){
        return new SoireeRepository();
    },
    SoireeServiceInterface::class => function (ContainerInterface $c){
        return new SoireeService($c->get(SoireeRepositoryInterface::class));
    },

    GetSoireeByIDAction::class => function (ContainerInterface $c){
        return new GetSoireeByIDAction($c->get(SoireeServiceInterface::class));
    }

];