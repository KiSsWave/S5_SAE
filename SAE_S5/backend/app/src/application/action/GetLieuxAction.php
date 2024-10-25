<?php

namespace nrv\application\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\services\Soiree\SoireeServiceInterface;

class GetLieuxAction extends AbstractAction
{
    private SoireeServiceInterface $soireeService;

    public function __construct(SoireeServiceInterface $soireeService)
    {
        $this->soireeService = $soireeService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        


        try {

            $lieux = $this->soireeService->afficherLieux();

            $resultat = [
                "Lieux" => []
            ];

            foreach ($lieux as $lieu) {

                $images = $lieu->images.split(",");

                $lieuxDTO[] = [
                    "ID" => $lieu->id,
                    "nom" => $lieu->nom,
                    "adresse" => $lieu->adresse,
                    "image" => $lieu->image
                ];
            }


            $rs->getBody()->write(json_encode($paniersDTO));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['error' => 'Erreur lors de la récupération du panier']));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
