<?php


namespace nrv\core\dto;

use DateTime;
use nrv\core\domain\entities\Soiree\Commande;


class CommandeDTO extends DTO
{
    public string $iduser;
    public string $idsoiree;
    public DateTime $date_achat;
    public int $placesvendues;

    public string $typetarif;

    public function __construct(Commande $commande, string $iduser)
    {
        $this->iduser = $iduser;
        $this->idsoiree = $commande->getIdSoiree();
        $this->date_achat = $commande->getDateAchat();
        $this->placesvendues = $commande->getPlacesVendues();
        $this->typetarif = $commande->getTypeTarif();
    }
}
