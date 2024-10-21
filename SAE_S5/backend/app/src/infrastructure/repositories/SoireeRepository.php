<?php

namespace nrv\infrastructure\repositories;

use nrv\infrastructure\DatabaseConnection;
use nrv\core\repositoryInterfaces\SoireeRepositoryInterface;
use PDO;

class SoireeRepository implements SoireeRepositoryInterface
{
    private PDO $pdo;


    public function __construct()
    {
        $this->pdo = DatabaseConnection::getPDO('Soirees');
    }

    public function getSoireeByID(int $id){
        $stmt = $this->pdo->prepare("SELECT * FROM soirees WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




}