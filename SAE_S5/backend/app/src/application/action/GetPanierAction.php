<?php

namespace nrv\application\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\services\Soiree\SoireeServiceInterface;

class GetPanierAction extends AbstractAction
{
    private SoireeServiceInterface $soireeService;

    public function __construct(SoireeServiceInterface $soireeService)
    {
        $this->soireeService = $soireeService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $queryParams = $rq->getQueryParams();
        $user = $rq->getAttribute('auth');
        $userid = $user->id;

        try {
            $paniers = $this->soireeService->recuperationPanier($userid);

            $resultat = [
                "Panier" => []
            ];

            foreach ($paniers as $panierDTO) {
                $resultat["Panier"][] = [
                    "idSoiree" => $panierDTO->idsoiree,
                    "idUser" => $panierDTO->iduser,
                    "NbPlaces" => $panierDTO->nbplaces,
                    "Categorie" => $panierDTO->categorie,
                    "Montant" => $panierDTO->montant,
                    "links" => [
                        "self" => [
                            "href" => "/panier/" . $panierDTO->idsoiree
                        ]
                    ]
                ];
            }

            $rs->getBody()->write(json_encode($resultat));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        } catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['error' => 'Erreur lors de la récupération du panier']));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
}
