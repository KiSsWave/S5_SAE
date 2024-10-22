<?php

namespace nrv\infrastructure\repositories;

use DateTime;
use nrv\core\domain\entities\Spectacle\Spectacle;
use nrv\infrastructure\DatabaseConnection;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;
use PDO;

class SpectacleRepository implements SpectacleRepositoryInterface
{
    private PDO $pdo;

    private array $spectacles = [];


    public function __construct()
    {
        $this->pdo = DatabaseConnection::getPDO('nrv');
        $spectacles = $this->pdo->query("SELECT * FROM spectacles")->fetchAll(PDO::FETCH_ASSOC);
        $horaire = new DateTime($spectacles['horaire']);
        $this->spectacles[$spectacles['id']] = new Spectacle($spectacles['titre'], $spectacles['description'],$spectacles['images'], $spectacles['url'], $spectacles['style'], $horaire );
        $this->spectacles[$spectacles['id']]->setID($spectacles['id']);
    }

    public function getSpectacleByID(int $id){
        $stmt = $this->pdo->prepare("SELECT * FROM spectacles WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSpectacles(): array
    {
        return $this->spectacles;
    }




}