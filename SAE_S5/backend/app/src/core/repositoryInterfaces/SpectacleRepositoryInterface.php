<?php

namespace nrv\core\repositoryInterfaces;

use DateTime;

interface SpectacleRepositoryInterface
{
    public function getSpectacleByID(string $id);
    public function SoireBySpectaclesID(string $id);
    public function getSpectacles();

    public function ajoutSpectacle(string $titre, string $description, array $images, string $url, string $style, DateTime $horaire );
}