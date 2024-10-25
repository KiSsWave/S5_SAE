<?php

namespace nrv\infrastructure\repositories;

use DateTime;
use Exception;
use nrv\core\domain\entities\Soiree\Billet;
use nrv\core\domain\entities\Soiree\Commande;
use nrv\core\domain\entities\Soiree\Lieu;
use nrv\core\domain\entities\Soiree\Panier;
use nrv\core\domain\entities\Soiree\Soiree;
use nrv\core\domain\entities\Spectacle\SpectacleSoiree;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use nrv\core\repositoryInterfaces\SoireeRepositoryInterface;
use nrv\infrastructure\DatabaseConnection;
use PDO;

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

    public function getLieux(){
        $stmt = $this->pdo->prepare("SELECT * FROM LIEUX");
        $stmt->execute();
        $lieuxData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lieux = [];
        foreach ($lieuxData as $lieu){
            $lieureturn = new Lieu($lieu['nom'], $lieu['adresse'], $lieu['nbplacesassises'], $lieu['nbplacesdebout'],$lieu['images']);
            $lieureturn->setID($lieu['id']);
            $lieux[] = $lieureturn;
        }
        return $lieux;
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

    public function getPanierByUser(string $iduser): array
    {
        $stmt = $this->pdo->prepare("
        SELECT nbplaces, categorie, montant, idsoiree
        FROM Paniers
        WHERE iduser = :iduser
    ");
        $stmt->execute(['iduser' => $iduser]);

        $paniersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $paniers = [];
        foreach ($paniersData as $panierData) {
            $paniers[] = new Panier(
                $panierData['nbplaces'],
                $panierData['categorie'],
                $panierData['montant'],
                $panierData['idsoiree']
            );
        }

        return $paniers;
    }

    public function getCommandesByUser(string $iduser) : array
    {
        $stmt = $this->pdo->prepare("
        SELECT * 
        FROM commandes 
        WHERE iduser = :iduser
    ");
        $stmt->execute(['iduser' => $iduser]);
        $commandesData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $commandes = [];
        foreach ($commandesData as $commandeData) {
            $dateAchat = new DateTime($commandeData['date_achat']);
            $commandes[] = new Commande(
                $commandeData['idsoiree'],
                $dateAchat,
                $commandeData['placesvendues']
            );
        }
        return $commandes;

    }




    public function getSoirees(): array{
        return $this->soirees;
    }

    public function creerBillet(Billet $billet, string $id_acheteur): string
    {
        $uuid = $this->generateUuid();

        $stmt = $this->pdo->prepare("
        SELECT u.nom AS nom_acheteur, s.datesoiree AS datehorairesoiree,
            CASE 
                WHEN :typetarif = 'Standard' THEN s.tarif 
                ELSE s.tarifreduit 
            END AS prix 
        FROM users u
        JOIN soirees s ON s.id = :reference
        WHERE u.id = :id_acheteur
    ");


        error_log('Reference: ' . $billet->getReference());
        error_log('Acheteur ID: ' . $id_acheteur);
        error_log('Type Tarif: ' . $billet->getTypeTarif());

        $stmt->bindValue(':reference', $billet->getReference());
        $stmt->bindValue(':id_acheteur', $id_acheteur);
        $stmt->bindValue(':typetarif', $billet->getTypeTarif());

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);



        if (!$result) {
            throw new Exception('Aucune information trouvée pour l\'acheteur ou la soirée. Reference: ' . $billet->getReference() . ', Acheteur ID: ' . $id_acheteur . ', Type Tarif: ' . $billet->getTypeTarif());
        }


        $nomAcheteur = $result['nom_acheteur'];
        $dateHoraireSoiree = new DateTime($result['datehorairesoiree']);
        $prix = $result['prix'];

        $insertStmt = $this->pdo->prepare("
        INSERT INTO billets (id, id_acheteur, nom_acheteur, reference, datehorairesoiree, typetarif, prix)
        VALUES (:id, :id_acheteur, :nom_acheteur, :reference, :datehorairesoiree, :typetarif, :prix)
    ");


        $dateHoraireSoireeFormatted = $dateHoraireSoiree->format('Y-m-d H:i:s');


        $insertStmt->bindValue(':id', $uuid);
        $insertStmt->bindValue(':id_acheteur', $id_acheteur);
        $insertStmt->bindValue(':nom_acheteur', $nomAcheteur);
        $insertStmt->bindValue(':reference', $billet->getReference());
        $insertStmt->bindValue(':datehorairesoiree', $dateHoraireSoireeFormatted);
        $insertStmt->bindValue(':typetarif', $billet->getTypeTarif());
        $insertStmt->bindValue(':prix', $prix);

        $billet->setID($uuid);
        $insertStmt->execute();


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

    public function creerPanier(string $idSoiree, string $iduser, int $montant, string $categorie, int $nbplaces): void
    {
        $stmt = $this->pdo->prepare("
        INSERT INTO Paniers (idsoiree, iduser, montant, categorie, nbplaces) 
        VALUES (:idsoiree, :iduser, :montant, :categorie, :nbplaces)  
        ON DUPLICATE KEY UPDATE nbplaces = nbplaces + VALUES(nbplaces), montant = montant +VALUES(montant)
    ");
        try {
            $stmt->execute([
                'idsoiree' => $idSoiree,
                'iduser' => trim($iduser),
                'montant' => $montant,
                'categorie' => $categorie,
                'nbplaces' => $nbplaces
            ]);
        } catch (\PDOException $e) {

            echo 'Erreur d\'exécution : ' . $e->getMessage();
            throw $e;
        }
    }

    public function getIdSoireesByUser(string $iduser): array
    {
        $stmt = $this->pdo->prepare("
        SELECT DISTINCT idsoiree 
        FROM Paniers 
        WHERE iduser = :iduser
    ");
        $stmt->execute(['iduser' => $iduser]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getNbPlacesByUserAndSoiree(string $iduser, string $idsoiree): int
    {
        $stmt = $this->pdo->prepare("
        SELECT nbplaces 
        FROM Paniers 
        WHERE iduser = :iduser AND idsoiree = :idsoiree
    ");
        $stmt->execute([
            'iduser' => $iduser,
            'idsoiree' => $idsoiree
        ]);
        return $stmt->fetchColumn();
    }


    public function creerCommande(string $iduser, string $idsoiree, DateTime $date_achat, int $placesvendues): void
    {
        $stmt = $this->pdo->prepare("
        INSERT INTO commandes (iduser, idsoiree, date_achat, placesvendues) 
        VALUES (:iduser, :idsoiree, :date_achat, :placesvendues)
    ");
        $stmt->execute([
            'iduser' => $iduser,
            'idsoiree' => $idsoiree,
            'date_achat' => $date_achat->format('Y-m-d H:i:s'),
            'placesvendues' => $placesvendues
        ]);
    }



}