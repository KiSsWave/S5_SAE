<?php

namespace nrv\core\dto;

use nrv\core\domain\entities\Soiree\Lieu;
use nrv\core\dto\DTO;

class LieuDTO extends DTO{

    protected string $ID;
    protected string $nom;
    protected string $adresse;
    protected int $placesA;
    protected int $placesD;
    protected string $images;

    public function __construct(Lieu $l){

        $this->ID = $l->getID();
        $this->nom = $l->nom;
        $this->adresse = $l->adresse;
        $this->placesA = $l->placesA;
        $this->placesD = $l->placeD;
        $this->images = $l->images;

    }


    
}