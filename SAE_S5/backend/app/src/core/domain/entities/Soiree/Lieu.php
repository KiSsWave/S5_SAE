<?php

namespace nrv\core\domain\entities\Soiree;

use nrv\core\domain\entities\Entity;

class Lieu extends Entity
{
    protected string $nom;
    protected string $adresse;
    protected int $placesA;
    protected int $placeD;
    protected string $images;

    public function __construct(string $nom, string $adresse, int $pA, int $pD, string $images)
    {
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->placesA = $pA;
        $this->placeD = $pD;
        $this->images = $images;
    }
}