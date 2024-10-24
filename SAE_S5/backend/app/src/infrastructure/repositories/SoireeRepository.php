<?php

namespace nrv\infrastructure\repositories;

use DateTime;
use nrv\core\domain\entities\Soiree\Soiree;
use nrv\core\domain\entities\Spectacle\SpectacleSoiree;
use nrv\infrastructure\DatabaseConnection;
use nrv\core\repositoryInterfaces\SoireeRepositoryInterface;
use PDO;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use nrv\core\domain\entities\Soiree\Lieu;

class SoireeRepository implements SoireeRepositoryInterface
{
    private PDO $pdo;
    private array $soirees = [];

    public function __construct()
    {
        $this->pdo = DatabaseConnection::getPDO('nrv');
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
        $stmt = $this->pdo->prepare("SELECT * FROM SPECTACLESOIREE WHERE id_soiree = :id_soiree");
        $stmt->bindValue(':id_soiree', $id);
        $stmt->execute();

        $spectaclesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $spectacles = [];

        foreach ($spectaclesData as $ss) {
            $spectacles[] = new SpectacleSoiree($ss['id_soiree'], $ss['id_spectacle']);
        }

        return $spectacles;

    }

    public function getSoirees(): array{
        return $this->soirees;
    }

    public function creerBillet(string $nomAcheteur, string $reference, DateTime $dateHoraireSoiree, string $categorieTarif): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO billets (nomacheteur, reference, datehorairesoiree, categorietarif) VALUES (:nom_acheteur, :reference, :dateHoraireSoiree, :typetarif)");
        $stmt->execute([
            'nomacheteur' => $nomAcheteur,
            'reference' => $reference,
            'datehorairesoiree' => $dateHoraireSoiree->format('Y-m-d H:i:s'),
            'categorietarif' => $categorieTarif
        ]);
    }

    public function getLieuBySoireeId(string $id): Lieu
    {
        $stmt = $this->pdo->prepare("SELECT lieusoiree FROM soirees WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $stmt2 = $this->pdo->prepare("SELECT * FROM LIEUX WHERE id = :id");
        $stmt2->bindValue(':id', $stmt->fetch(PDO::FETCH_ASSOC)['lieusoiree']);
        $stmt2->execute();
        $lieu = $stmt2->fetch(PDO::FETCH_ASSOC);
        $result = new Lieu($lieu['nom'], $lieu['adresse'], $lieu['nbplacesassises'], $lieu['nbplacesdebout'],$lieu['images']);
        $result->setID($lieu['id']);
        return $result;
    }



}