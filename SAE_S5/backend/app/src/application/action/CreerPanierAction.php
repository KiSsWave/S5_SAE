<?php

namespace nrv\application\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\services\Soiree\SoireeServiceInterface;

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


        try {

            if (!$idsoiree || !$nbplaces || !$categorie || !$montant || !$userid) {
                throw new \InvalidArgumentException("Paramètre manquant dans la requête." 
                . "idsoiree: $idsoiree, nbplaces: $nbplaces, categorie: $categorie, montant: $montant, userid: $userid");
            }


            $panier = $this->soireeService->creationPanier($idsoiree, $userid, $montant, $categorie, $nbplaces);

            $rs->getBody()->write(json_encode($panier));
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
