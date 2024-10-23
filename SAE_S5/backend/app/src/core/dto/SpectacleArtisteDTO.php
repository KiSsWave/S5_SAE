<?php

namespace nrv\core\dto;

use nrv\core\domain\entities\Spectacle\SpectacleArtiste;
use nrv\core\dto\DTO;

class SpectacleArtisteDTO extends DTO
{
    protected string $idArtiste;
    protected string $idSpectacle;
    protected string $pseudonyme;
    protected string $nom;
    protected string $prenom;

    public function __construct(SpectacleArtiste $s)
    {
        $this->idArtiste= $s->idArtiste;
        $this->idSpectacle= $s->idSpectacle;
        $this->pseudonyme= $s->pseudonyme;
        $this->nom= $s->nom;
        $this->prenom= $s->prenom;
    }

}