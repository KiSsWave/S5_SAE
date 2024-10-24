<?php


namespace nrv\core\services\Soiree;
use nrv\core\dto\SoireeDTO;


interface SoireeServiceInterface
{
    public function afficherSoiree(string $ID): SoireeDTO;

    public function afficherSpectaclesSoiree(string $id): array;

    public function creationPanier(string $idsoiree, string $iduser,int $montant, string $categorie,int $nbplaces);
}