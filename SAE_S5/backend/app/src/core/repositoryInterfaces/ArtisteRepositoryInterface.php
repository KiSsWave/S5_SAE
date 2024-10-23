<?php

namespace nrv\core\repositoryInterfaces;

interface ArtisteRepositoryInterface
{ 
    public function getArtisteByID(string $id);
    public function getArtistes();
}