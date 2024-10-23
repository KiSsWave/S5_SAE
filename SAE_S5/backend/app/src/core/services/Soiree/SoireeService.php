<?php

namespace nrv\core\services\Soiree;

use Exception;
use nrv\core\domain\entities\Spectacle\SpectacleSoiree;
use nrv\core\dto\SoireeDTO;
use nrv\core\dto\SpectacleSoireeDTO;
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


    public function afficherSpectaclesSoiree(string $id): array
    {
        $spectaclesData = $this->soireeRepository->SpectaclesBySoireeID($id);
        $spectacles = [];
        foreach ($spectaclesData as $spectacle){
            $spectacles[] = new SpectacleSoireeDTO($spectacle);
        }
        return $spectacles;
    }

}