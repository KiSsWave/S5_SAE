<?php

namespace nrv\core\dto;

use DateTime;
use nrv\core\domain\entities\Soiree\Billet;
use nrv\core\dto\DTO;

class BilletDTO extends DTO
{
    protected string $ID;

    protected string $ID_acheteur;
    protected string $nomAcheteur;
    protected string $reference;

    protected DateTime $dateHoraireSoiree;
    protected string $typeTarif;

    protected int $prix;

    public function __construct(Billet $billet, string $ID_acheteur)
    {
        $this->ID = $billet->getID();
        $this->ID_acheteur = $ID_acheteur;
        $this->nomAcheteur = $billet->getNomAcheteur();
        $this->reference = $billet->getReference();
        $this->dateHoraireSoiree = $billet->getDateHoraireSoiree();
        $this->typeTarif = $billet->getTypeTarif();
        $this->prix = $billet->getPrix();
    }
}

