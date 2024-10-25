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
                $commandeData['placesvendues'],
                $commandeData['typetarif']
            );
        }
        return $commandes;

    }




    public function getSoirees(): array{
        return $this->soirees;
    }

    public function creerBillet(string $id_acheteur, array $commandesDTO, string $nom): array
    {
        $commandes = $commandesDTO;

        $billets = [];
        foreach ($commandes as $commande) {
            $soireeRef = $this->getSoireeByID($commande->idsoiree);
            $prix = 0;
            if($commande->typetarif == "reduit"){
                $prix = $soireeRef->tarifR;
            }else{
                $prix = $soireeRef->tarif;
            }
            
            for ($i = 0; $i < $commande->placesvendues; $i++) {
                $uuid = $this->generateUuid();
                $billet =  new Billet($id_acheteur, $commande->idsoiree, $commande->typetarif, $soireeRef->dateS, $prix);
                $billet->setID($uuid);
                $billets[] = $billet;
                
                $stmt = $this->pdo->prepare("INSERT INTO billets (id, id_acheteur, nom_acheteur, reference, typetarif, datehorairesoiree, prix) VALUES (:id, :id_acheteur, :nom_acheteur, :reference, :typetarif, :datehorairesoiree, :prix)");
                $stmt->execute([
                    'id' => $uuid,
                    'id_acheteur' => $id_acheteur,
                    'nom_acheteur' => $nom,
                    'reference' => $commande->idsoiree,
                    'typetarif' => $commande->typetarif,
                    'datehorairesoiree' => $soireeRef->dateS->format('Y-m-d H:i:s'),
                    'prix' => $prix
                ]);
                
            }
        }
        return $billets;

    }

    public function getBilletsByAcheteurId(string $idAcheteur): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM billets WHERE id_acheteur = :idAcheteur");
        $stmt->bindValue(':idAcheteur', $idAcheteur);
        $stmt->execute();

        $billetsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $billets = [];

        if (!$billetsData) {
            return [];
        }


        foreach ($billetsData as $billetData) {
            $date = new DateTime($billetData['datehorairesoiree']);
            $billet = new Billet(
                $billetData['nom_acheteur'],
                $billetData['reference'],
                $billetData['typetarif'],
                $date,
                $billetData['prix']
            );
            $billet->setID($billetData['id']);
            $billets[] = $billet;
        }

        return $billets;
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

    public function getTypeTarifByUserAndSoiree($iduser, $idsoiree): string
    {
        $stmt = $this->pdo->prepare("
        SELECT categorie 
        FROM Paniers 
        WHERE iduser = :iduser AND idsoiree = :idsoiree
    ");
        $stmt->execute([
            'iduser' => $iduser,
            'idsoiree' => $idsoiree
        ]);
        return $stmt->fetchColumn();
    }



    public function creerCommande(string $iduser, string $idsoiree, DateTime $date_achat, int $placesvendues, string $typetarif): void
    {
        $stmt = $this->pdo->prepare("
        INSERT INTO commandes (iduser, idsoiree, date_achat, placesvendues, typetarif) 
        VALUES (:iduser, :idsoiree, :date_achat, :placesvendues, :typetarif)
    ");
        $stmt->execute([
            'iduser' => $iduser,
            'idsoiree' => $idsoiree,
            'date_achat' => $date_achat->format('Y-m-d H:i:s'),
            'placesvendues' => $placesvendues,
            'typetarif' => $typetarif
        ]);
    }

    public function updateAvailablePlaces(string $idSoiree, int $nbplaces): void
    {
        $stmt = $this->pdo->prepare("
        UPDATE soirees 
        SET nbplaces = nbplaces - :nbplaces 
        WHERE id = :idSoiree AND nbplaces >= :nbplaces
    ");
        $stmt->execute([
            'nbplaces' => $nbplaces,
            'idSoiree' => $idSoiree
        ]);

        if ($stmt->rowCount() === 0) {
            throw new Exception("Pas assez de places disponibles pour cette soirée.");
        }
    }




}