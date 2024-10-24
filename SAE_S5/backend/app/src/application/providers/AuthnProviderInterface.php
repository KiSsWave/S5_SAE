<?php

namespace nrv\application\providers;



use DateTime;
use nrv\core\dto\AuthDTO;
use nrv\core\dto\CredentialDTO;
use PhpParser\Token;

interface AuthnProviderInterface
{
    public function register(CredentialDTO $c,string $nom, string $prenom, string $tel, string $birthdate, string $eligible, int $role);
    public function signin(CredentialDTO $c): AuthDTO;
    public function refresh(Token $token): AuthDTO;
    public function getSignedInUser(Token $token): AuthDTO;
}