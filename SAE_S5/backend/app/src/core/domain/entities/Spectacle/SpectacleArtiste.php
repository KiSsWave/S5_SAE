<?php

namespace nrv\core\domain\entities\Spectacle;

class SpectacleArtiste
{
    protected string $idSpectacle;
    protected string $idArtiste;
    protected string $pseudonyme;
    protected string $nom;
    protected string $prenom;

    public function __construct(string $idArtiste, string $idSpectacle, string $pseudonyme, string $nom, string $prenom)
    {
        $this->idArtiste = $idArtiste;
        $this->idSpectacle = $idSpectacle;
        $this->pseudonyme = $pseudonyme;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new \Exception("La propriété '$name' n'existe pas.");
    }
}