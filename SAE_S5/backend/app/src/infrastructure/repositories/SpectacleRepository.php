<?php

namespace nrv\infrastructure\repositories;

use DateTime;
use nrv\core\domain\entities\Spectacle\Spectacle;
use nrv\core\domain\entities\Spectacle\SpectacleSoiree;
use nrv\infrastructure\DatabaseConnection;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;
use nrv\core\domain\entities\Spectacle\SpectacleArtiste;
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
            $this->spectacles[$spectacle['id']] = new Spectacle($spectacle['titre'], $spectacle['description'],$spectacle['images'], $spectacle['urlvideo'], $spectacle['style'], $horaire );
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

    public function SoireBySpectaclesID(string $id){
        $stmt = $this->pdo->prepare("SELECT * FROM SPECTACLESOIREE WHERE id_spectacle = :id_spectacle");
        $stmt->bindValue(':id_spectacle', $id);
        $stmt->execute();

        $soireeData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $soiree = [];

        foreach ($soireeData as $ss) {
            $soiree[] = new SpectacleSoiree($ss['id_soiree'], $ss['id_spectacle']);
        }

        return $soiree;

    }

    public function getSpectaclesByDate(DateTime $date): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM spectacles WHERE DATE(horaire) = :date");
        $stmt->bindValue(':date', $date->format('Y-m-d'));
        $stmt->execute();
        $spectacles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $filteredSpectacles = [];
        foreach ($spectacles as $spectacle) {
            $horaire = new DateTime($spectacle['horaire']);
            $filteredSpectacles[] = new Spectacle(
                $spectacle['titre'],
                $spectacle['description'],
                $spectacle['images'],
                $spectacle['urlVideo'],
                $spectacle['style'],
                $horaire
            );
        }

        return $filteredSpectacles;
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

    public function getArtisteBySpectacleID(string $id){
        $stmt = $this->pdo->prepare("SELECT * FROM ARTISTESPECTACLE natural join ARTISTES WHERE id_spectacle = :id_spectacle");
        $stmt->bindValue(':id_spectacle', $id);
        $stmt->execute();

        $artistesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $artistes = [];

        foreach ($artistesData as $as) {
            $artistes[] = new SpectacleArtiste($as['id_artiste'], $as['id_spectacle'], $as['pseudonyme'], $as['nom'], $as['prenom']);
        }

        return $artistes;
    }



}