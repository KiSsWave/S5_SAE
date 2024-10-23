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

    public function __construct(string $e, int $r, string $p=""){
        $this->email = $e;
        $this->role = $r;
        $this->password = "";
    }


    public function getId(): string
    {
        return $this->id;
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