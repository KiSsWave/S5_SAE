<?php

namespace nrv\infrastructure\repositories;

use nrv\infrastructure\DatabaseConnection;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;
use PDO;

class SpectacleRepository implements SpectacleRepositoryInterface
{
    private PDO $pdo;


    public function __construct()
    {
        $this->pdo = DatabaseConnection::getPDO('Spectacles');
    }

    public function getSpectacleByID(int $id){
        $stmt = $this->pdo->prepare("SELECT * FROM soirees WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




}