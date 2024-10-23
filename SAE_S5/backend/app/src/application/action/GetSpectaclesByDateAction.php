<?php

namespace nrv\application\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\services\Spectacle\SpectacleServiceInterface;
use DateTime;

class GetSpectaclesByDateAction extends AbstractAction
{
    private SpectacleServiceInterface $spectacleService;

    public function __construct(SpectacleServiceInterface $s)
    {
        $this->spectacleService = $s;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $params = $rq->getQueryParams();
        $dateParam = $params['date'] ?? null;

        try {
            if (!$dateParam) {
                $rs->getBody()->write(json_encode(['error' => 'Date non fournie']));
                return $rs
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400);
            }

            $date = new DateTime($dateParam);
            $spectacles = $this->spectacleService->afficherSpectaclesParDate($date);

            if (empty($spectacles)) {
                $rs->getBody()->write(json_encode(['message' => 'Aucun spectacle trouvé pour cette date']));
                return $rs
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(404);
            }

            $resultat = [
                "Spectacles" => array_map(fn($spectacle) => [
                    "Titre" => $spectacle->titre,
                    "Horaire" => $spectacle->horaire->format('Y-m-d H:i:s'),
                    "Image" => $spectacle->images[0] ?? null
                ], $spectacles),
            ];

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

