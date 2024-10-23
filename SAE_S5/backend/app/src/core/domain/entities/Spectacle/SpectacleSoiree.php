<?php

namespace nrv\core\domain\entities\Spectacle;

class SpectacleSoiree
{
    protected string $idSpectacle;

    protected string $idSoiree;

    public function __construct(string $idSoiree, string $idSpectacle)
    {
        $this->idSoiree = $idSoiree;
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