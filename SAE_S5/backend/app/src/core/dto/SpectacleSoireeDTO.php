<?php

namespace nrv\core\dto;

use nrv\core\domain\entities\Spectacle\SpectacleSoiree;
use nrv\core\dto\DTO;

class SpectacleSoireeDTO extends DTO
{
    protected string $idSoiree;
    protected string $idSpectacle;

    public function __construct(SpectacleSoiree $s){
        $this->idSoiree = $s->idSoiree;
        $this->idSpectacle = $s->idSpectacle;
    }

}