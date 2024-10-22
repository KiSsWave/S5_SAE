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
        foreach ($spectacles as $spectacle) {
            $horaire = new DateTime($spectacle['horaire']);
            $this->spectacles[$spectacle['id']] = new Spectacle($spectacle['titre'], $spectacle['description'], $spectacle['images'], $spectacle['urlvideo'], $spectacle['style'], $horaire);
            $this->spectacles[$spectacle['id']]->setID($spectacle['id']);
        }
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