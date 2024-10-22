<?php

namespace nrv\infrastructure\repositories;

use DateTime;
use nrv\core\domain\entities\Spectacle\Spectacle;
use nrv\core\domain\entities\Spectacle\SpectacleSoiree;
use nrv\infrastructure\DatabaseConnection;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;
use PDO;

class SpectacleRepository implements SpectacleRepositoryInterface
{
    private PDO $pdo;

    private array $spectacles = [];

    private array $spectaclessoirees = [];
    public function __construct()
    {
        $this->pdo = DatabaseConnection::getPDO('nrv');
        $spectacles = $this->pdo->query("SELECT * FROM spectacles")->fetchAll(PDO::FETCH_ASSOC);
        $spectaclesSoirees = $this->pdo->query("SELECT * FROM SPECTACLESOIREE")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($spectacles as $spectacle) {
            $horaire = new DateTime($spectacle['horaire']);
            $this->spectacles[$spectacle['id']] = new Spectacle($spectacle['titre'], $spectacle['description'], $spectacle['images'], $spectacle['urlvideo'], $spectacle['style'], $horaire);
            $this->spectacles[$spectacle['id']]->setID($spectacle['id']);
        }
        foreach ($spectaclesSoirees as $ss){
            $this->spectaclessoirees[] = new SpectacleSoiree($ss['id_soiree'], $ss['id_spectacle']);
        }
    }

    public function getSpectacleByID(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM spectacles WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSoireeBySpectacleID(string $id){
        $stmt = $this->pdo->prepare("SELECT * FROM SPECTACLESOIREE WHERE id_spectacle = :id_spectacle");
        $stmt->bindValue(':id_spectacle', $id);
        $stmt->execute();

        $soireesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $soirees = [];

        foreach ($soireesData as $ss) {
            $soirees[] = new SpectacleSoiree($ss['id_soiree'], $ss['id_spectacle']);
        }

        return $soirees;


    }

    public function getSpectacles(): array
    {
        return $this->spectacles;
    }




}