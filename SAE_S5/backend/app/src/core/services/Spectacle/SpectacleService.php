<?php

namespace nrv\core\services\Spectacle;


use DateTime;
use nrv\core\domain\entities\Spectacle\Spectacle;
use nrv\core\dto\SpectacleDTO;
use nrv\core\dto\SpectacleSoireeDTO;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;



class SpectacleService implements SpectacleServiceInterface
{

    private SpectacleRepositoryInterface $spectacleRepository;

    public function __construct(SpectacleRepositoryInterface $s){
        $this->spectacleRepository = $s;
    }

    public function afficherSpectacle(String $ID): SpectacleDTO
    {
        $spectacle = $this->spectacleRepository->getSpectacleByID($ID);
        $spectacleDto = new SpectacleDTO($spectacle);
        return $spectacleDto;
    }

    public function afficherSpectacles(): array
    {
        $spectacles = $this->spectacleRepository->getSpectacles();
        $spectaclesDto = [];
        foreach ($spectacles as $spectacle) {
            $spectaclesDto[] = new SpectacleDTO($spectacle);
        }
        return $spectaclesDto;
    }

    public function afficherSpectaclesSoiree(string $id): array
    {
        $soireeData = $this->spectacleRepository->getSoireeBySpectacleID($id);
        $soiree = [];
        foreach ($soireeData as $s){
            $soiree[] = new SpectacleSoireeDTO($s);
        }
        return $soiree;
    }

    public function afficherSpectaclesParDate(DateTime $date): array
    {
        $spectacles = $this->spectacleRepository->getSpectaclesByDate($date);
        $spectaclesDto = [];
        foreach ($spectacles as $spectacle) {
            $spectaclesDto[] = new SpectacleDTO($spectacle);
        }
        return $spectaclesDto;
    }

}