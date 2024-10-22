<?php

namespace nrv\core\services\Spectacle;

use nrv\core\dto\SpectacleDTO;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;



class SpectacleService implements SpectacleServiceInterface
{

    private SpectacleRepositoryInterface $spectacleRepository;

    public function __construct(SpectacleRepositoryInterface $s){
        $this->spectacleRepository = $s;
    }

    public function afficherSpectacle(String $ID): SpectacleDTO
    {
        try{
            $soireeDto = $this->soireeRepository->getSoireeByID($ID);
            return new SoireeDTO($soireeDto);
        }catch(Exception $e) {
            throw new Exception("erreur");
        }
    }

}