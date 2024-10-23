<?php

namespace nrv\core\domain\entities\Spectacle;

class SpectacleArtiste
{
    protected string $idSpectacle;

    protected string $idArtiste;

    public function __construct(string $idArtiste, string $idSpectacle)
    {
        $this->idArtiste = $idArtiste;
        $this->idSpectacle = $idSpectacle;
    }

    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new \Exception("La propriété '$name' n'existe pas.");
    }
}