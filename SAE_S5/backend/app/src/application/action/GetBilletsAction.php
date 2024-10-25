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

        try {
            $billets = $this->soireeService->afficherBillets($userid);

            foreach ($billets as $b){
                $resultat = ["Billet" => [
                    "Acheteur" => $b->nom_acheteur,
                    "Reference" => $b->reference,
                    "Date" => $b->dateHoraireSoiree->format('Y-m-d H:i:sP'),
                    "TypeTarif" => $b->typeTarif,
                    "prix" => $b->prix,
                ]];
            }

            $rs->getBody()->write(json_encode($resultat));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }catch (\Exception $e){
            $rs->getBody()->write(json_encode(['error' => 'Soirée non trouvée']));

            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }


    }
}