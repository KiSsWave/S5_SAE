<?php


namespace nrv\core\services\Soiree;
use nrv\core\dto\SoireeDTO;


interface SoireeServiceInterface
{
    public function afficherSoiree(string $ID): SoireeDTO;

    public function afficherSpectaclesSoiree(string $id): array;

    public function creationBillet(array $data);

    public function afficherLieuSoiree(string $id);

    public function afficherLieux(): array;




    public function creationPanier(string $idsoiree, string $iduser,int $montant, string $categorie,int $nbplaces);

    public function recuperationPanier(string $iduser): array;


}