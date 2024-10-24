<?php

namespace nrv\core\services\auth;

use nrv\application\providers\JWTManager;
use nrv\core\services\auth\AuthzServiceInterface;

class AuthzService implements AuthzServiceInterface
{

    private JWTManager $JWTManager;

    public  function __construct(JWTManager $JWTManager)
    {
        $this->JWTManager = $JWTManager;
    }

    public function isOrganisateur(string $token): bool
    {
        $payload = $this->JWTManager->decodeToken($token);
        return isset($payload['role']) && $payload['role'] === '2';


    }

    public function isUser(string $token): bool
    {
        $payload = $this->JWTManager->decodeToken($token);
        return isset($payload['role']) && $payload['role'] === '1';
    }


}