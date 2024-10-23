<?php

namespace nrv\application\action;

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
                foreach ($spectacleDto as $s){
                    $soiree = $this->spectacleService->afficherSpectaclesSoiree($s->ID);
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
                    "DetailSoiree" => [
                        "href" => "/soiree/" . $soiree[0]->idSoiree,
                        "method" => "GET",
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
