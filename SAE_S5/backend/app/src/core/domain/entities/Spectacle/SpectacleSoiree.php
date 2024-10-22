<?php

namespace nrv\core\domain\entities\Spectacle;

class SpectacleSoiree
{
    protected string $idSoiree;
    protected string $idSpectacle;

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

        // Si la propriété n'existe pas, tu peux lever une exception ou retourner null
        throw new \Exception("La propriété '$name' n'existe pas.");
    }
}