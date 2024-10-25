<?php

namespace nrv\core\services\auth;

use nrv\application\providers\JWTManager;
use nrv\core\repositoryInterfaces\UserRepositoryInterface;
use nrv\core\services\auth\AuthzServiceInterface;

class AuthzService implements AuthzServiceInterface
{


    private UserRepositoryInterface $userRepository;

    public  function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isOrganisateur(string $id): bool
    {
        $user = $this->userRepository->getUserByID($id);
        return isset($user['role']) && $user['role'] === '2';


    }

    public function isUser(string $id): bool
    {
        $user = $this->userRepository->getUserByID($id);
        return isset($user['role']) && $user['role'] === '1';
    }


}