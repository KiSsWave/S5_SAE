<?php
try {

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=Soirees', 'gclm', 'gclm');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie !\n";
} catch (PDOException $e) {
    echo "Échec de la connexion : " . $e->getMessage() . "\n";
}
