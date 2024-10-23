<?php

namespace nrv\core\domain\entities\Artiste;

use nrv\core\domain\entities\Entity;

class Artiste extends Entity
{
    protected string $pseudonyme;
    protected string $nom;
    protected string $prenom;

    public function __construct(string $pseudonyme, string $nom, string $prenom)
    {
        $this->pseudonyme = $pseudonyme;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }
}