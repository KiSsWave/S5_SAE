<?php

namespace nrv\core\repositoryInterfaces;

interface SpectacleRepositoryInterface
{
    public function getSpectacleByID(int $id);
    public function SoireBySpectaclesID(string $id);
    public function getSpectacles();
}