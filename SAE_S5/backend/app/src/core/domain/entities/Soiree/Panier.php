<?php


namespace nrv\core\domain\entities\Soiree;

use nrv\core\domain\entities\Entity;

class Panier extends Entity
{
    protected string $nbPlaces;
    protected string $categorie;
    protected string $montant;
    protected string $idSoiree;

    public function __construct(string $nbPlaces, string $categorie, string $montant, string $idSoiree)
    {
        $this->nbPlaces = $nbPlaces;
        $this->categorie = $categorie;
        $this->montant = $montant;
        $this->idSoiree = $idSoiree;
    }

    public function getNbPlaces(): string { return $this->nbPlaces; }
    public function getCategorie(): string { return $this->categorie; }
    public function getMontant(): string { return $this->montant; }
    public function getIdSoiree(): string { return $this->idSoiree; }
}






