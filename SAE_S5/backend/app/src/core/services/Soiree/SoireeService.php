<?php

namespace nrv\core\services\Soiree;

use Exception;
use nrv\core\dto\SoireeDTO;
use nrv\core\repositoryInterfaces\SoireeRepositoryInterface;


class SoireeService implements SoireeServiceInterface
{

    private SoireeRepositoryInterface $soireeRepository;

    public function __construct(SoireeRepositoryInterface $s){
        $this->soireeRepository = $s;
    }

    public function afficherSoiree(string $ID): SoireeDTO
    {
            $soiree = $this->soireeRepository->getSoireeByID($ID);
            $soireedto = new SoireeDTO($soiree);
            return $soireedto;

    }
}