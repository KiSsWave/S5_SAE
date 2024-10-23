<?php

namespace nrv\application\providers;

use nrv\core\services\auth\AuthDTO;
use nrv\core\services\auth\AuthnServiceInterface;
use nrv\core\services\auth\CredentialDTO;

class JWTAuthnProvider implements AuthnProviderInterface
{

    private $jwtManager;
    private $authService;

    public function __construct(JWTManager $jwtManager, AuthnServiceInterface $authService)
    {
        $this->jwtManager = $jwtManager;
        $this->authService = $authService;
    }


    public function register(CredentialDTO $c, int $role)
    {
        $this->authService->createUser($c, $role);
    }

    public function signin(CredentialDTO $c): AuthDTO
    {
        return $this->authService->ByCredentials($c);
    }
}