<?php

namespace nrv\core\dto;

use nrv\core\domain\entities\Soiree\Panier;
use nrv\core\dto\DTO;

class PanierDTO extends DTO
{
    protected string $idsoiree;
    protected string $iduser;
    protected int $nbplaces;
    protected string $categorie;
    protected int $montant;

    public function __construct(Panier $panier,string $iduser)
    {
        $this->idsoiree = $panier->getIdSoiree();
        $this->iduser = $iduser;
        $this->nbplaces = $panier->getNbPlaces();
        $this->categorie = $panier->getCategorie();
        $this->montant = $panier->getMontant();
    }
}
