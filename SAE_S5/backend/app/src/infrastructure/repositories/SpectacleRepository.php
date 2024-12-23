<?php

namespace nrv\infrastructure\repositories;

use DateTime;
use nrv\core\domain\entities\Soiree\Billet;
use nrv\core\domain\entities\Spectacle\Spectacle;
use nrv\core\domain\entities\Spectacle\SpectacleSoiree;
use nrv\core\dto\BilletDTO;
use nrv\infrastructure\DatabaseConnection;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;
use nrv\core\domain\entities\Spectacle\SpectacleArtiste;
use PDO;
use PDOException;
use Ramsey\Uuid\Uuid;

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
            $this->spectacles[$spectacle['id']] = new Spectacle(
                $spectacle['titre'],
                $spectacle['description'],
                $spectacle['images'],
                $spectacle['urlvideo'],
                $spectacle['style'],
                $horaire
            );
            $this->spectacles[$spectacle['id']]->setID($spectacle['id']);
        }
    }


    
    public function getSpectacleByID(string $id){
        if(!isset($this->spectacles[$id])){
            return null;
        }
        return $this->spectacles[$id];
    }

    public function getSpectacles(): array
    {
        return $this->spectacles;
    }

    public function SoireBySpectaclesID(string $id)
    {
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

    public function getSpectaclesFiltres(?DateTime $date = null, ?string $style = null, ?string $lieu = null): array
    {
        $query = "SELECT DISTINCT s.* FROM spectacles s
              JOIN SPECTACLESOIREE ss ON s.id = ss.id_spectacle
              JOIN soirees so ON ss.id_soiree = so.id
              JOIN LIEUX l ON so.lieusoiree = l.id
              WHERE 1=1";

        $params = [];

        if ($date) {
            $query .= " AND DATE(s.horaire) = :date";
            $params[':date'] = $date->format('Y-m-d');
        }

        if ($style) {
            $query .= " AND s.style = :style";
            $params[':style'] = $style;
        }

        if ($lieu) {
            $query .= " AND l.nom = :lieu";
            $params[':lieu'] = $lieu;
        }

        $stmt = $this->pdo->prepare($query);
        foreach ($params as $key => &$value) {
            $stmt->bindParam($key, $value);
        }
        $stmt->execute();

        $spectacles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $filteredSpectacles = [];

        foreach ($spectacles as $spectacle) {
            if (isset($spectacle['id'])) {
                $horaire = new DateTime($spectacle['horaire']);
                $filteredSpectacles[] = new Spectacle(
                    $spectacle['titre'],
                    $spectacle['description'],
                    $spectacle['images'],
                    $spectacle['urlvideo'],
                    $spectacle['style'],
                    $horaire
                );
                $filteredSpectacles[count($filteredSpectacles) - 1]->setID($spectacle['id']);
            }
        }

        return $filteredSpectacles;
    }

    public function getSoireeBySpectacleID(string $id)
    {
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

    public function getArtisteBySpectacleID(string $id)
    {
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

    public function ajoutSpectacle(string $titre, string $description, string $images, string $url, string $style, DateTime $horaire)
    {
        try{
            $stmt = $this->pdo->prepare("INSERT INTO Spectacles(id,titre, description, images, urlvideo, style, horaire) VALUES(:id,:titre, :description, :images, :url, :style, :horaire)");
            $stmt->execute([
                'id' => Uuid::uuid4()->toString(),
                'titre' => $titre,
                'description' => $description,
                'images' => $images,
                'url' => $url,
                'style' => $style,
                'horaire' => $horaire->format('Y-m-d\TH:i:sP')
            ]);
        }catch (PDOException $e) {
            // Affiche un message d'erreur plus détaillé
            echo "Erreur lors de l'insertion du spectacle : " . $e->getMessage();
        }

    }


}
