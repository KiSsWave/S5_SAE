<?php

namespace nrv\core\dto;

use nrv\core\dto\DTO;

class PanierDTO extends DTO
{
    protected string $idsoiree;
    protected string $iduser;
    protected int $nbplaces;
    protected string $categorie;

    protected int $montant;

    public function __construct(string $idsoiree, string $iduser, int $nbplaces, int $montant, string $categorie)
    {
        $this->idsoiree = $idsoiree;
        $this->iduser = $iduser;
        $this->nbplaces = $nbplaces;
        $this->categorie = $categorie;
        $this->montant = $montant;
    }

}