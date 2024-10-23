<?php
try {

    $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
    echo $hashedPassword;
} catch (PDOException $e) {
    echo "Échec de la connexion : " . $e->getMessage() . "\n";
}
