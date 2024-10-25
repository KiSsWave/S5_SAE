<?php

namespace nrv\application\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\services\Soiree\SoireeService;

class CreateBilletAction extends AbstractAction
{
    private SoireeService $soireeService;

    public function __construct(SoireeService $soireeService)
    {
        $this->soireeService = $soireeService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        $user = $rq->getAttribute('auth');
        $id_acheteur = $user->id;
        $nom_acheteur = $user->nom;
        $prenom_acheteur = $user->prenom;
        $nom = $nom_acheteur . ' ' . $prenom_acheteur;


        try {

            $billetDTO = $this->soireeService->creationBillet([
                'id_acheteur' => $id_acheteur,
                'nom_acheteur' => $nom
            ]);


            $rs->getBody()->write(json_encode($billetDTO));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(201);

        } catch (\Exception $e) {

            $rs->getBody()->write($e->getMessage());
            return $rs->withStatus(500);
        }
    }
}
