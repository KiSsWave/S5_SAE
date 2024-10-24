<?php

namespace nrv\core\services\auth;

interface AuthzServiceInterface
{

    public function isOrganisateur(string $token): bool;
    public function isUser(string $token): bool;



}