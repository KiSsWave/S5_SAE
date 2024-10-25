<?php

class Panier extends Entity
{
    protected string $nbPlaces;
    protected string $categorie;
    protected string $montant;

    public function __construct(string $nbPlaces, string $categorie, string $montant)
    {
        $this->nbPlaces = $nbPlaces;
        $this->categorie = $categorie;
        $this->montant = $montant;
    }

    public function getNbPlaces(): string
    {
        return $this->nbPlaces;
    }

    public function getCategorie(): string
    {
        return $this->categorie;
    }

    public function getMontant(): string
    {
        return $this->montant;
    }

}






