<?php

namespace nrv\infrastructure\repositories;

use DateTime;
use nrv\core\domain\entities\Soiree\Billet;
use nrv\core\domain\entities\Soiree\Soiree;
use nrv\core\domain\entities\Spectacle\SpectacleSoiree;
use nrv\core\dto\BilletDTO;
use nrv\infrastructure\DatabaseConnection;
use nrv\core\repositoryInterfaces\SoireeRepositoryInterface;
use PDO;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;

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

    public function creerBillet(Billet $billet, string $id_acheteur): BilletDTO
    {

        $stmt = $this->pdo->prepare("
            INSERT INTO billets (id_acheteur, nomAcheteur, reference, dateHoraireSoiree, typeTarif, prix)
            VALUES (:id_acheteur, :nomAcheteur, :reference, :dateHoraireSoiree, :typeTarif, :prix)
        ");

        $stmt->execute();
        $id = $this->pdo->lastInsertId();
        return new BilletDTO($billet, $id_acheteur);
    }








}