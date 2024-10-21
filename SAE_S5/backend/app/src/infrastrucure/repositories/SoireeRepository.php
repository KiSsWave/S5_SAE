<?php

class SoireeRepository implements \repositoryInterfaces\SoireeRepositoryInterface
{
    private PDO $pdo;


    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getSoireeByID(int $id){
        $stmt = $this->pdo->prepare("SELECT * FROM soirees WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




}