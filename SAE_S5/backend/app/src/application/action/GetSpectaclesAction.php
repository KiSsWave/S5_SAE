<?php

namespace nrv\application\action;

use DateTime;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\services\Spectacle\SpectacleServiceInterface;

class GetSpectaclesAction extends AbstractAction
{
    private SpectacleServiceInterface $spectacleService;

    public function __construct(SpectacleServiceInterface $s)
    {
        $this->spectacleService = $s;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $spectacles = $this->spectacleService->afficherSpectacles();
            $resultat = [
                "Spectacles" => []
            ];
            foreach ($spectacles as $spectacleDto) {
                    $soiree_tab = $this->spectacleService->afficherSoireesParSpectacleID($spectacleDto->ID);
                foreach ($soiree_tab as $s){
                    $soiree = $s;
                }
                $resultat["Spectacles"][] = [
                    "Titre" => $spectacleDto->titre,
                    "Date" => $spectacleDto->horaire,
                    "Image" => $spectacleDto->images[0],
                    "links" => [
                        "self" => [
                            "href" => "/spectacle/" . $spectacleDto->ID
                        ]
                    ],
                    "SoireeAssociee" => [
                        "href" => "/soiree/" . $soiree->idSoiree
                    ]
                ];
            }

            // Return the response with JSON data
            $rs->getBody()->write(json_encode($resultat));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        } catch (\Exception $e) {
            // Handle internal errors
            $rs->getBody()->write(json_encode(['error' => 'Erreur interne du serveur']));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
}
