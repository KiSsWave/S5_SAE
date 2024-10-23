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
            $date = new DateTime($u['birthdate']);
            $this->users[$u['id']] = new User($u['email'],$u['nom'], $u['prenom'], $u['numerotel'],$date,$u['eligible'], $u['role']);
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
        $this->users[$user->getID()] = $user;
        $insert =$this->pdo->prepare('INSERT INTO USERS (ID, email, passwd,nom, prenom, numerotel, birthdate,eligible, role) VALUES (:id, :email, :password,:nom,:prenom,:numerotel,:birthdate,:eligible, :role)');
        $birthdate = $user->getBirthdate()->format('Y-m-d');
        $insert->execute( [
            'id' => $user->getID(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'numerotel' => $user->getNumerotel(),
            'birthdate' => $birthdate,
            'eligible' => $user->getEligible(),
            'role' => $user->getRole()
        ]);
        return $user->getID();
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