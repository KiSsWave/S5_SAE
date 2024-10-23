<?php

namespace nrv\core\dto;

class ArtisteDTO extends DTO{
    protected string $ID;
    protected string $pseudonyme;
    protected string $nom;
    protected string $prenom;

    public function __construct(Artiste $a){
        $this->ID = $a->getID();
        $this->pseudonyme = $a->pseudonyme;
        $this->nom = $a->nom;
        $this->prenom = $a->prenom;
    }
}