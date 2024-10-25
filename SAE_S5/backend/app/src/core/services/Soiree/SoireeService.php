<?php

namespace nrv\core\services\Soiree;

use DateTime;
use Exception;
use nrv\core\domain\entities\Soiree\Billet;
use nrv\core\domain\entities\Spectacle\SpectacleSoiree;
use nrv\core\dto\BilletDTO;
use nrv\core\dto\PanierDTO;
use nrv\core\dto\SoireeDTO;
use nrv\core\dto\SpectacleSoireeDTO;
use nrv\core\dto\LieuDTO;
use nrv\core\repositoryInterfaces\SoireeRepositoryInterface;


class SoireeService implements SoireeServiceInterface
{

    private SoireeRepositoryInterface $soireeRepository;

    public function __construct(SoireeRepositoryInterface $s)
    {
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
        foreach ($spectaclesData as $spectacle) {
            $spectacles[] = new SpectacleSoireeDTO($spectacle);
        }
        return $spectacles;
    }


    public function creationBillet(array $data): BilletDTO
    {

        $billet = new Billet('', $data['reference'], $data['typeTarif']);
        $this->soireeRepository->creerBillet($billet, $data['id_acheteur']);
        return new BilletDTO($billet, $data['id_acheteur']);
    }


    public function afficherLieuSoiree(string $id): LieuDTO
    {
        $lieu = $this->soireeRepository->getLieuBySoireeId($id);
        $lieuDTO = new LieuDTO($lieu);
        return $lieuDTO;
    }

    public function creationPanier(string $idsoiree, string $iduser,int $montant, string $categorie, int $nbplaces)
    {
        $this->soireeRepository->creerPanier($idsoiree, $iduser,$montant,$categorie, $nbplaces);
        return new PanierDTO($idsoiree, $iduser, $montant, $categorie, $nbplaces);
    }

    public function recuperationPanier(string $iduser)
    {
        $paniers = $this->soireeRepository->getPanierByUser($iduser);
        $paniersDTO = [];
        foreach ($paniers as $panier) {
            $paniersDTO[] = new PanierDTO($panier['idsoiree'], $panier['iduser'], $panier['montant'], $panier['categorie'], $panier['nbplaces']);
        }
        return $paniersDTO;
    }


}