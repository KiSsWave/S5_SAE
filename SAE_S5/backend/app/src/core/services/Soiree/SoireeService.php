<?php

namespace nrv\core\services\Soiree;

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
        try{
            $soireeDto = $this->soireeRepository->getSoireeByID($ID);
            return new SoireeDTO($soireeDto);
        }catch(Exception $e) {
            throw new Exception("erreur");
        }
    }
}