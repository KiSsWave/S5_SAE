<?php

use nrv\core\dto\SoireeDTO;

interface SoireeServiceInterface
{
    public function afficherSoiree(string $ID): SoireeDTO;
}