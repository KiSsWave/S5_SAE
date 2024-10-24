<?php

namespace nrv\core\services\auth;

use DateTime;
use nrv\core\dto\AuthDTO;
use nrv\core\dto\CredentialDTO;

interface AuthnServiceInterface
{
    public function createUser(CredentialDTO $c,string $nom,string $prenom, string $tel, DateTime $birthdate, string $eligible,int $role);

    public function byCredentials(CredentialDTO $c): AuthDTO;


}