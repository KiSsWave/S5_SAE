<?php

use nrv\core\dto\SoireeDTO;

require_once __DIR__ . '/../vendor/autoload.php';

$soireeService = new nrv\core\services\Soiree\SoireeService(new nrv\infrastructure\repositories\SoireeRepository());


// Test de la méthode afficherSoiree
$id = 'SOO1';
try {
    $soireeDTO = $soireeService->afficherSoiree($id);

    if ($soireeDTO instanceof SoireeDTO) {
        echo "Test réussi : La méthode afficherSoiree retourne un objet SoireeDTO.\n";
        echo "Nom : " . $soireeDTO->nom . "\n";
        echo "Thématique : " . $soireeDTO->thematique . "\n";
    } else {
        echo "Test échoué : La méthode afficherSoiree ne retourne pas un objet SoireeDTO.\n";
    }
} catch (Exception $e) {
    echo "Test échoué : " . $e->getMessage() . "\n";
}
