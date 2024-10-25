<?php


namespace nrv\core\domain\entities\Soiree;

use DateTime;
use nrv\core\domain\entities\Entity;


class Commande extends Entity
{

    private string $idsoiree;
    private \DateTime $date_achat;
    private int $placesvendues;

    public function __construct(string $idsoiree, DateTime $date_achat, int $placesvendues)
    {
        $this->idsoiree = $idsoiree;
        $this->date_achat = $date_achat;
        $this->placesvendues = $placesvendues;
    }

    public function getIdUser(): string
    {
        return $this->iduser;
    }

    public function getIdSoiree(): string
    {
        return $this->idsoiree;
    }

    public function getDateAchat(): \DateTime
    {
        return $this->date_achat;
    }

    public function getPlacesVendues(): int
    {
        return $this->placesvendues;
    }
}
