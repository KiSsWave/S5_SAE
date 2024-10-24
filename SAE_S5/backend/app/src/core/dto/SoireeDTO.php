<?php

namespace nrv\core\dto;


use DateTime;
use nrv\application\providers\Soiree;

class SoireeDTO extends DTO{
    protected string $ID;
    protected string $nom;
    protected string $thematique;

    protected DateTime $dateSoiree;
    protected string $lieuSoiree;
    protected int $nbPlaces;
    protected float $tarif;
    protected float $tarifReduit;

    public function __construct(Soiree $s){
        $this->ID = $s->getID();
        $this->nom = $s->nom;
        $this->thematique = $s->thematique;
        $this->dateSoiree = $s->dateS;
        $this->lieuSoiree = $s->lieu;
        $this->nbPlaces = $s->nbPlaces;
        $this->tarif = $s->tarif;
        $this->tarifReduit = $s->tarifR;
    }




}
