<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\Soiree\Billet;

interface SoireeRepositoryInterface
{

    public function getSoireeByID(string $id);

    public function SpectaclesBySoireeID(string $id);

    public function getSoirees();

    public function getLieux();

    public function creerPanier(string $idSoiree, string $iduser, int $montant, string $categorie, int $nbplaces);

    public function getPanierByUser(string $iduser);
    public function effacerPanierByUserId(string $iduser);
    public function effacerCommandeByUserId(string $iduser);

    public function creerBillet(string $id_acheteur, array $commandesDTO, string $nom): array;

    public function getLieuBySoireeId(string $id);
    public function getCommandesByUser(string $iduser) : array;









}