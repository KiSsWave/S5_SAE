<?php

use Psr\Container\ContainerInterface;
use nrv\core\services\Soiree\SoireeServiceInterface;
use nrv\infrastructure\repositories\SoireeRepository;

return[

    SoireeServiceInterface::class => function (ContainerInterface $c){
        return new SoireeRepository();
    }
];