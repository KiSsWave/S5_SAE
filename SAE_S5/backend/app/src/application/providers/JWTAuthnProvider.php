<?php

namespace nrv\application\providers;

use nrv\core\domain\entities\User\User;
use nrv\core\dto\AuthDTO;
use nrv\core\services\auth\AuthnServiceInterface;
use PhpParser\Token;
use nrv\core\dto\CredentialDTO;

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
        $authDTO = $this->authService->ByCredentials($c);
        $authDTO->setToken($this->jwtManager->createAccessToken([
            'id' => $authDTO->getId(),
            'email' => $authDTO->getEmail(),
            'role' => $authDTO->getRole()
        ]));

        return $authDTO;
    }

    public function refresh(Token $token): AuthDTO
    {
        // TODO: Implement refresh() method.
    }

    public function getSignedInUser(Token $token): AuthDTO
    {
        $decodedToken = $this->jwtManager->decodeToken($token);
        $email = $decodedToken['email'];
        $role = $decodedToken['role'];
        return new AuthDTO(new User($email, $role));
    }
}