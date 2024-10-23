<?php

namespace nrv\infrastructure\repositories;

use nrv\core\domain\entities\Artiste\Artiste;
use nrv\core\repositoryInterfaces\ArtisteRepositoryInterface;

class ArtisteRepository implements ArtisteRepositoryInterface
{

    private PDO $pdo;
    private array $artistes = [];

    public function __construct()
    {
        $this->pdo = DatabaseConnection::getPDO('nrv');
        $artistes = $this->pdo->query("SELECT * FROM artistes")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($artistes as $artiste) {
            $this->artistes[$artiste['id']] = new Artiste($artiste['pseudonyme'], $artiste['nom'], $artiste['prenom']);
            $this->artistes[$artiste['id']]->setID($artiste['id']);
        }
    }

    public function getArtisteByID(string $id)
    {
        if (!isset($this->artistes[$id])) {
            throw new RepositoryEntityNotFoundException('Artiste not found');
        }

        return $this->artistes[$id];
    }

    public function getArtistes(): array
    {
        return $this->artistes;
    }

}