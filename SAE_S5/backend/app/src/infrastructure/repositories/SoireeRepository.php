<?php

namespace nrv\infrastructure\repositories;

use DateTime;
use nrv\core\domain\entities\Soiree\Soiree;
use nrv\infrastructure\DatabaseConnection;
use nrv\core\repositoryInterfaces\SoireeRepositoryInterface;
use PDO;
use repositoryInterfaces\RepositoryEntityNotFoundException;

class SoireeRepository implements SoireeRepositoryInterface
{
    private PDO $pdo;
    private array $soirees = [];

    public function __construct()
    {
        $this->pdo = DatabaseConnection::getPDO('Soirees');
        $soirees = $this->pdo->query("SELECT * FROM soirees")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($soirees as $soiree) {
            $date = new DateTime($soiree['datesoiree']);
            $this->soirees[$soiree['id']] = new Soiree($soiree['nom'], $soiree['thematique'], $date, $soiree['lieusoiree'], $soiree['nbplaces'], $soiree['tarif'], $soiree['tarifreduit']);
            $this->soirees[$soiree['id']]->setID($soiree['id']);
        }
    }

    public function getSoireeByID(string $id):Soiree{
        if (!isset($this->soirees[$id])) {
            throw new RepositoryEntityNotFoundException('Soiree not found');
        }

        return $this->soirees[$id];
    }

    public function SpectaclesBySoireeID(string $id){
        
    }

    public function getSoirees(): array{
        return $this->soirees;
    }




}