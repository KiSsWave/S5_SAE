<?php

namespace nrv\core\domain\entities\User;

use DateTime;
use nrv\core\domain\entities\Entity;

class User extends Entity
{
    protected string $email;
    protected string $password;
    protected string $nom;
    protected string $prenom;
    protected string $numerotel;
    protected DateTime $birthdate;
    protected string $eligible;

    protected int $role;

    public function __construct(string $e, string $p, string $n, string $pr, string $ntel, DateTime $b, string $eli, int $r ){
        $this->email = $e;
        $this->password = $p;
        $this->nom = $n;
        $this->prenom = $pr;
        $this->numerotel = $ntel;
        $this->birthdate = $b;
        $this->eligible = $eli;
        $this->role = $r;
    }

}