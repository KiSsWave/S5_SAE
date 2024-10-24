<?php

namespace nrv\core\services\Soiree;

use DateTime;
use Exception;
use nrv\core\domain\entities\Soiree\Billet;
use nrv\core\domain\entities\Spectacle\SpectacleSoiree;
use nrv\core\dto\SoireeDTO;
use nrv\core\dto\SpectacleSoireeDTO;
use nrv\core\dto\LieuDTO;
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

    public function creationBillet(array $data): void
    {
        $dateHoraireSoiree = new DateTime($data['dateHoraireSoiree']);
        $billet = new Billet($data['nomAcheteur'], $data['reference'], $data['typeTarif'], $dateHoraireSoiree, (int)$data['prix']);
        $this->soireeRepository->creerBillet($billet, $data['id_user']);
    }

    public function afficherLieuSoiree(string $id): LieuDTO
    {
        $lieu = $this->soireeRepository->getLieuBySoireeId($id);
        $lieuDTO = new LieuDTO($lieu);
        return $lieuDTO;
    }

}