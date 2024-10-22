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
        $this->pdo = DatabaseConnection::getPDO('nrv');
        $soirees = $this->pdo->query("SELECT * FROM soirees")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($soirees as $soiree) {
            $date = new DateTime($soiree['date']);
            $this->soirees[$soiree['id']] = new Soiree($soiree['nom'], $soiree['thematique'], $date, $soiree['lieu'], $soiree['nbPlaces'], $soiree['tarif'], $soiree['tarifReduit']);
        }
    }

    public function getSoireeByID(string $id){
        if (!isset($this->soirees[$id])) {
            throw new RepositoryEntityNotFoundException('Soiree not found');
        }

        return $this->soirees[$id];
    }




}