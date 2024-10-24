<?php

namespace nrv\core\domain\entities\User;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\dto\AuthDTO;

class User extends Entity
{
    protected string $email;
    protected string $password = '';
    protected string $nom;
    protected string $prenom;
    protected string $numerotel;
    protected DateTime $birthdate;
    protected string $eligible;

    protected int $role;

    public function __construct(string $e,string $n, string $pr, string $numerotel,DateTime $b,string $eligible,int $r, string $p=""){
        $this->email = $e;
        $this->role = $r;
        $this->password = "";
        $this->nom= $n;
        $this->prenom=$pr;
        $this->numerotel = $numerotel;
        $this->eligible = $eligible;
        $this->birthdate =$b;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): int
    {
        return $this->role;
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
    public function getEligible(): string
    {
        return $this->eligible;
    }

    /**
     * @return string
     */
    public function getNumerotel(): string
    {
        return $this->numerotel;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setRole(int $role): void
    {
        $this->role = $role;
    }

    public function toDTO(): AuthDTO
    {
        return new AuthDTO($this);
    }

}