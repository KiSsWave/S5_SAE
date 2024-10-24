<?php

namespace nrv\core\domain\entities\Soiree;

use DateTime;
use nrv\core\domain\entities\Entity;

class Billet extends Entity
{
    protected string $nomAcheteur;
    protected string $reference;
    protected DateTime $dateHoraireSoiree;
    protected string $typeTarif;
    protected int $prix;

    public function __construct(?string $nomAcheteur, string $reference, string $typeTarif,DateTime $dateHoraireSoiree, int $prix)
    {
        $this->nomAcheteur = $nomAcheteur;
        $this->reference = $reference;
        $this->dateHoraireSoiree = $dateHoraireSoiree;
        $this->typeTarif = $typeTarif;
        $this->prix = $prix;
    }

    public function getNomAcheteur(): string
    {
        return $this->nomAcheteur;
    }
    public function getReference(): string
    {
        return $this->reference;
    }
    public function getDateHoraireSoiree(): DateTime
    {
        return $this->dateHoraireSoiree;
    }
    public function getTypeTarif(): string
    {
        return $this->typeTarif;
    }
    public function getPrix(): int
    {
        return $this->prix;
    }


}
