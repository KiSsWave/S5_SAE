<?php

namespace nrv\application\action;

use nrv\application\action\AbstractAction;
use nrv\core\services\Soiree\SoireeServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreerPanierAction extends AbstractAction
{
    private SoireeServiceInterface $soireeService;

    public function __construct(SoireeServiceInterface $soireeService)
    {
        $this->soireeService = $soireeService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        $data = $rq->getParsedBody();

        $idsoiree = $data['idsoiree'] ?? null;
        $nbplaces = $data['nbplaces'] ?? null;
        $categorie = $data['categorie'] ?? null;
        $montant = $data['montant'] ?? null;
        $user = $rq->getAttribute('auth');
        $userid = $user->id;

        try{
            $panier = $this->soireeService->creationPanier($idsoiree, $userid,$montant, $categorie, $nbplaces);

            $rs->getBody()->write(json_encode($panier));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(201);
        }catch(\Exception $e){
            $rs->getBody()->write(json_encode(['error' => 'Erreur interne du serveur']));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
}