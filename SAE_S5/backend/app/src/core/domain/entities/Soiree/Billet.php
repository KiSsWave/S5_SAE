<?php

namespace nrv\core\domain\entities\Soiree;

use nrv\core\domain\entities\Entity;

class Billet extends Entity
{
    protected string $nomAcheteur;
    protected string $reference;
    protected string $dateHoraireSoiree;
    protected string $typeTarif;
    protected int $prix;

    public function __construct(?string $nomAcheteur, string $reference, string $typeTarif,string $dateHoraireSoiree, int $prix)
    {
        $this->nomAcheteur = $nomAcheteur;
        $this->reference = $reference;
        $this->dateHoraireSoiree = $dateHoraireSoiree;
        $this->typeTarif = $typeTarif;
        $this->prix = $prix;
    }
}
