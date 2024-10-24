<?php

namespace nrv\core\repositoryInterfaces;

interface SoireeRepositoryInterface
{

    public function getSoireeByID(string $id);

    public function SpectaclesBySoireeID(string $id);

    public function getSoirees();

    public function creerPanier(string $idSoiree, string $iduser, int $montant, string $categorie, int $nbplaces);


}