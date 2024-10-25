<?php

namespace nrv\application\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\services\Soiree\SoireeServiceInterface;

class CreerCommandeAction extends AbstractAction
{
    private SoireeServiceInterface $soireeService;

    public function __construct(SoireeServiceInterface $soireeService)
    {
        $this->soireeService = $soireeService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

       $user = $rq->getAttribute('auth');
       $iduser = $user->id;

        try {

            if (!$iduser) {
                throw new \InvalidArgumentException("Paramètre manquant dans la requête.");
            }


            $this->soireeService->creationCommande($iduser);


            $rs->getBody()->write(json_encode(['success' => 'Commande créée avec succès']));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (\InvalidArgumentException $e) {

            $rs->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (\Exception $e) {

            $rs->getBody()->write(json_encode(['error' => 'Erreur interne du serveur']));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}

