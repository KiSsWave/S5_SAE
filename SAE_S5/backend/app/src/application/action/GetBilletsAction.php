<?php

namespace nrv\application\action;

use nrv\application\action\AbstractAction;
use nrv\core\services\Soiree\SoireeServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetBilletsAction extends AbstractAction
{
    private SoireeServiceInterface $soireeService;

    public function __construct(SoireeServiceInterface $soireeService){
        $this->soireeService = $soireeService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $user = $rq->getAttribute('auth');
        $userid = $user->id;

        $resultat = [
            'Billets' => []
        ];

        try {
            $billets = $this->soireeService->afficherBillets($userid);

            foreach ($billets as $b){
                $resultat['Billets'][] = [
                    "Id" => $b->ID,
                    "Acheteur" => $b->nomAcheteur,
                    "Reference" => $b->reference,
                    "Date" => $b->dateHoraireSoiree->format('Y-m-d H:i'),
                    "TypeTarif" => $b->typeTarif,
                    "prix" => $b->prix,
                ];
            }

            $rs->getBody()->write(json_encode($resultat));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }catch (\Exception $e){
            $rs->getBody()->write(json_encode(['error' => 'Problème lors de la récupération des billets']));

            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }


    }
}