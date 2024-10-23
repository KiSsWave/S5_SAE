<?php

namespace nrv\core\repositoryInterfaces;

interface SpectacleRepositoryInterface
{
    public function getSpectacleByID(int $id);
    public function getSoireeBySpectacleID(string $id);
    public function getSpectacles();
}