<?php

namespace nrv\core\services\auth;

use nrv\core\dto\AuthDTO;
use nrv\core\dto\CredentialDTO;

interface AuthnServiceInterface
{
    public function createUser(CredentialDTO $c, int $role);

    public function byCredentials(CredentialDTO $c): AuthDTO;


}