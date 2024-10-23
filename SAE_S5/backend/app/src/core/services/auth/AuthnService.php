<?php

namespace nrv\core\services\auth;

use DateTime;
use nrv\core\domain\entities\User\User;
use nrv\core\repositoryInterfaces\UserRepositoryInterface;
use nrv\core\services\auth\AuthnServiceInterface;
use nrv\core\dto\AuthDTO;
use nrv\core\dto\CredentialDTO;
use Ramsey\Uuid\Uuid;

class AuthnService implements AuthnServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(CredentialDTO $credentials,string $nom, string $prenom, string $tel, DateTime $birthdate, string $eligible, int $role): string
    {
        $user = new User($credentials->getEmail(),$nom,$prenom,$tel, $birthdate, $eligible, $role);
        $user->setID(Uuid::uuid4()->toString());
        $user->setPassword(password_hash($credentials->getPassword(), PASSWORD_DEFAULT));
        return $this->userRepository->save($user);
    }

    public function byCredentials(CredentialDTO $credentials): AuthDTO
    {
        $user = $this->userRepository->getUserByEmail($credentials->getEmail());
        if ($user && password_verify($credentials->getPassword(), $user->getPassword())) {
            return new AuthDTO($user);
        } else {
            throw new AuthServiceBadDataException('Erreur 400 : Email ou mot de passe incorrect', 400);
        }
    }

}