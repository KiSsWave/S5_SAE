<?php

use nrv\infrastructure\repositories\SpectacleRepository;
use nrv\core\dto\BilletDTO;

$spectacleRepo = new \nrv\infrastructure\repositories\SpectacleRepository();


$billet = new \nrv\core\domain\entities\Soiree\Billet(
    'John Doe',
    'REF12345',
    'Standard',
    '2024-10-30 20:00:00',
    50
);


$billet->setID('unique-id-123');

try {

    $spectacleRepo->creerBillets($billet);
    echo "Billet créé avec succès.\n";
} catch (Exception $e) {
    echo "Erreur lors de la création du billet : " . $e->getMessage() . "\n";
}


$stmt = $spectacleRepo->getPdo()->prepare("SELECT * FROM billets WHERE id = :id");
$stmt->bindValue(':id', $billet->getID());
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    echo "Billet trouvé dans la base de données : \n";
    print_r($result);
} else {
    echo "Billet non trouvé dans la base de données.\n";
}


