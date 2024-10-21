<?php

use nrv\core\dto\SoireeDTO;
use repositoryInterfaces\SoireeRepositoryInterface;

class SoireeService implements SoireeServiceInterface
{

    private SoireeRepositoryInterface $soireeRepository;

    public function __construct(SoireeRepositoryInterface $s){
        $this->soireeRepository = $s;
    }

    public function afficherSoiree(string $ID): SoireeDTO
    {
        // TODO: Implement afficherSoiree() method.
    }
}