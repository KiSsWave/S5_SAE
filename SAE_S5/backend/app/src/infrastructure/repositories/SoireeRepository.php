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
use nrv\core\domain\entities\Soiree\Lieu;

class SoireeRepository implements SoireeRepositoryInterface
{
    private PDO $pdo;
    private array $soirees = [];
    private array $billets = [];

    public function __construct()
    {
        $this->pdo = DatabaseConnection::getPDO('nrv');
        $soirees = $this->pdo->query("SELECT * FROM soirees")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($soirees as $soiree) {
            $date = new DateTime($soiree['datesoiree']);
            $this->soirees[$soiree['id']] = new Soiree($soiree['nom'], $soiree['thematique'], $date, $soiree['lieusoiree'], $soiree['nbplaces'], $soiree['tarif'], $soiree['tarifreduit']);
            $this->soirees[$soiree['id']]->setID($soiree['id']);
        }
        $billets = $this->pdo->query("SELECT * FROM billets")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($billets as $billet) {
            $date = new DateTime($billet['datehorairesoiree']);
            $this->billets[$billet['id']] = new Billet($billet['nom_acheteur'], $billet['reference'], $billet['typetarif'], $date, $billet['prix']);
            $this->billets[$billet['id']]->setID($billet['id']);
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

    public function creerBillet(Billet $billet, string $id_acheteur): string
    {

        $uuid = $this->generateUuid();

        $stmt = $this->pdo->prepare("
        INSERT INTO billets (id, id_acheteur, nom_acheteur, reference, datehorairesoiree, typetarif, prix)
        VALUES (:id, :id_acheteur, :nom_acheteur, :reference, :datehorairesoiree, :typetarif, :prix)
    ");

        $dateHoraireSoiree = $billet->getDateHoraireSoiree()->format('Y-m-d H:i:s');


        $stmt->bindValue(':id', $uuid);
        $stmt->bindValue(':id_acheteur', $id_acheteur);
        $stmt->bindValue(':nom_acheteur', $billet->getNomAcheteur());
        $stmt->bindValue(':reference', $billet->getReference());
        $stmt->bindValue(':datehorairesoiree', $dateHoraireSoiree);
        $stmt->bindValue(':typetarif', $billet->getTypeTarif());
        $stmt->bindValue(':prix', $billet->getPrix());

        $stmt->execute();


        return $uuid;
    }

    private function generateUuid(): string
    {
        return sprintf('%s-%s-%s-%s-%s',
            bin2hex(random_bytes(4)),
            bin2hex(random_bytes(2)),
            bin2hex(random_bytes(2)),
            bin2hex(random_bytes(2)),
            bin2hex(random_bytes(6))
        );
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