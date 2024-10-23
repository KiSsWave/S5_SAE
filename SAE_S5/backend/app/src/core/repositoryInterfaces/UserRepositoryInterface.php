<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\User\User;

interface UserRepositoryInterface
{
    public function getUsers(): array;
    public function save(User $user): string;
    public function getUserByEmail(string $email): User;

}