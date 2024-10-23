<?php

namespace nrv\infrastructure\repositories;

use DateTime;
use nrv\core\domain\entities\User\User;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use nrv\core\repositoryInterfaces\UserRepositoryInterface;
use nrv\infrastructure\DatabaseConnection;
use PDO;

class UserRepository implements UserRepositoryInterface
{

    private PDO $pdo;

    private array $users = [];

    public function __construct()
    {
        $this->pdo = DatabaseConnection::getPDO('nrv');
        $users = $this->pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users as $u) {
            $this->users[$u['id']] = new User($u['email'], $u['role']);
            $this->users[$u['id']]->setID($u['id']);
            $this->users[$u['id']]->setPassword($u['passwd']);
        }

    }

    public function getUsers(): array
    {
        return $this->users;
    }


    public function save(User $user): string
    {
        // TODO: Implement save() method.
    }

    public function getUserByEmail(string $email): User
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        throw new RepositoryEntityNotFoundException('User not found');
    }

}