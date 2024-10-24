<?php

namespace nrv\application\providers;

use DateTime;
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


    public function register(CredentialDTO $c,string $nom, string $prenom, string $tel, string $birthdateString, string $eligible,int $role)
    {
        $birthdate = new DateTime($birthdateString);
        $this->authService->createUser($c,$nom,$prenom,$tel, $birthdate, $eligible,$role);
    }

    public function signin(CredentialDTO $c): AuthDTO
    {
        $authDTO = $this->authService->ByCredentials($c);
        $authDTO->setToken($this->jwtManager->createAccessToken([
            'id' => $authDTO->getId(),
            'email' => $authDTO->getEmail(),
            'nom' => $authDTO->getNom(),
            'prenom' => $authDTO->getPrenom(),
            'numerotel' => $authDTO->getNumerotel(),
            'birthdate' => $authDTO->getBirthdate(),
            'eligible' => $authDTO->getEligible(),
            'role' => $authDTO->getRole()
        ]));

        return $authDTO;
    }

    public function refresh(Token $token): AuthDTO
    {
        // TODO: Implement refresh() method.
    }

    public function getSignedInUser(string $token): AuthDTO
    {
        $decodedToken = $this->jwtManager->decodeToken($token);
        $email = $decodedToken['email'];
        $nom = $decodedToken['nom'];
        $prenom = $decodedToken['prenom'];
        $numerotel = $decodedToken['numerotel'];
        $birthdate = new DateTime($decodedToken['birthdate']->date);
        $eligible = $decodedToken['eligible'];
        $role = $decodedToken['role'];
        $user = new User($email,$nom, $prenom, $numerotel, $birthdate, $eligible, $role);
        $user->setID($decodedToken['id']);

        return new AuthDTO($user);
    }
}