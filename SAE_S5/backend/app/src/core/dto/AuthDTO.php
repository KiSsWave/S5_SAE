<?php

namespace nrv\core\dto;

use DateTime;
use nrv\core\domain\entities\User\User;
use nrv\core\dto\DTO;

class AuthDTO extends DTO
{
    protected string $id;
    protected string $email;
    protected string $nom;
    protected string $prenom;
    protected string $numerotel;
    protected DateTime $birthdate;
    protected string $eligible;
    protected int $role;
    protected string $token;
    protected string $refreshToken;

    public function __construct(User $user)
    {
        $this->id = $user->getID();
        $this->email = $user->getEmail();
        $this->nom = $user->getNom();
        $this->prenom = $user->getPrenom();
        $this->numerotel = $user->getNumerotel();
        $this->birthdate = $user->getBirthdate();
        $this->eligible = $user->getEligible();
        $this->role = $user->getRole();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @return string
     */
    public function getNumerotel(): string
    {
        return $this->numerotel;
    }

    /**
     * @return DateTime
     */
    public function getBirthdate(): DateTime
    {
        return $this->birthdate;
    }

    /**
     * @return string
     */
    public function getEligible(): string
    {
        return $this->eligible;
    }

    public function getRole(): int
    {
        return $this->role;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function setRefreshToken(string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }
}