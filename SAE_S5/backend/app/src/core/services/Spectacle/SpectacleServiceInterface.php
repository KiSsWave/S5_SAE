<?php

namespace nrv\core\services\Spectacle;
use nrv\core\dto\SpectacleDTO;

interface SpectacleServiceInterface
{
    public function afficherSpectacle(string $ID): SpectacleDTO;
}