<?php

namespace nrv\application\action;

use nrv\application\action\AbstractAction;
use nrv\application\providers\AuthnProviderInterface;
use nrv\core\dto\CredentialDTO;
use nrv\core\services\auth\AuthServiceBadDataException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;

class RegisterAction extends AbstractAction
{

    private AuthnProviderInterface $authnProvider;

    public function __construct(AuthnProviderInterface $authnProvider){
        $this->authnProvider = $authnProvider;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $nom = $data['nom'];
        $prenom = $data['prenom'];
        $numerotel = $data['numerotel'];
        $birthdate = $data['birthdate'];
        $eligible = $data['eligible'];
        $role = $data['role'];

        try{
            $this->authnProvider->register(new CredentialDTO($email, $password), $nom, $prenom, $numerotel, $birthdate, $eligible, $role);

        }catch(AuthServiceBadDataException $e){
            throw new HttpBadRequestException($rq, $e->getMessage());
        }

        return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);

    }
}