<?php

namespace Soiree;

use Faker\Core\DateTime;

class Soiree extends \Entity
{
    protected string $nom;
    protected string $thematique;
    protected DateTime $dateS;
    protected string $lieu;
    protected int $nbPlaces;
    protected float $tarif;
    protected float $tarifR;

    public function __construct(string $n, string $theme,DateTime $d, string $l, int $places, float $t, float $tr){
        $this->nom = $n;
        $this->thematique = $theme;
        $this->dateS = $d;
        $this->lieu =$l;
        $this->nbPlaces = $places;
        $this->tarif = $t;
        $this->tarifR = $tr;
    }
}