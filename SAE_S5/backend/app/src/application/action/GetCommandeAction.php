<?php

namespace nrv\application\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\services\Soiree\SoireeServiceInterface;

class GetCommandeAction extends AbstractAction
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

            $commandes = $this->soireeService->recuperationCommandesByUser($iduser);

            if (empty($commandes)) {
                return $rs->withHeader('Content-Type', 'application/json')->withStatus(204); // No content
            }

            $rs->getBody()->write(json_encode($commandes));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['error' => 'Erreur interne du serveur']));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
