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
            $queryParams = $rq->getQueryParams();
            $dateParam = $queryParams['date'] ?? null;
            $styleParam = $queryParams['style'] ?? null;
            $lieuParam = $queryParams['lieu'] ?? null;


            $date = $dateParam ? new DateTime($dateParam) : null;


            $spectacles = $this->spectacleService->afficherSpectaclesFiltres($date, $styleParam, $lieuParam);

            $resultat = [
                "Spectacles" => []
            ];

            foreach ($spectacles as $spectacleDto) {
                $soiree_tab = $this->spectacleService->afficherSoireesParSpectacleID($spectacleDto->ID);

                $soireeAssociee = [
                        "idSoiree" => $soiree_tab[0]->idSoiree,
                        "href" => "/soiree/" . $soiree_tab[0]->idSoiree
                ];

                $resultat["Spectacles"][] = [
                    "Titre" => $spectacleDto->titre,
                    "Date" => $spectacleDto->horaire->format('Y-m-d'),
                    "Horaire" => $spectacleDto->horaire->format('H:i'),
                    "Image" => $spectacleDto->images[0],
                    "links" => [
                        "self" => [
                            "href" => "/spectacle/" . $spectacleDto->ID
                        ]
                    ],
                    "SoireeAssociee" => $soireeAssociee
                ];
            }

            $rs->getBody()->write(json_encode($resultat));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        } catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['error' => 'Erreur interne du serveur']));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
}
