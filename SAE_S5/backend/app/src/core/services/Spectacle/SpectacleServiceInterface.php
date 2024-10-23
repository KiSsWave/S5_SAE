<?php

namespace nrv\core\services\Spectacle;
use nrv\core\dto\SpectacleDTO;

interface SpectacleServiceInterface
{
    public function afficherSpectacle(string $ID): SpectacleDTO;
    public function afficherSpectaclesSoiree(string $id): array;

    public function afficherSoireesParSpectacleID(string $id): array;

    public function afficherArtistesParSpectacleID(string $id): array;

    public function afficherSpectaclesFiltres(\DateTime $date, string $style, string $lieu): array;


}