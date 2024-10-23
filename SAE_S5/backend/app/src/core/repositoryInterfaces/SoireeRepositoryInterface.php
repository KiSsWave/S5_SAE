<?php

namespace nrv\core\repositoryInterfaces;

interface SoireeRepositoryInterface
{

    public function getSoireeByID(string $id);

    public function SpectaclesBySoireeID(string $id);

    public function getSoirees();


}