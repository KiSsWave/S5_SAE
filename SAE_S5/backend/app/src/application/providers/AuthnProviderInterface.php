<?php

namespace nrv\application\providers;



use nrv\core\dto\AuthDTO;

interface AuthnProviderInterface
{
    public function register(CredentialDTO $c, int $role);
    public function signin(CredentialDTO $c): AuthDTO;
}