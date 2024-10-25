<?php

namespace nrv\application\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\services\Soiree\SoireeServiceInterface;

class UpdatePlacesAction extends AbstractAction
{
    private SoireeServiceInterface $soireeService;

    public function __construct(SoireeServiceInterface $soireeService)
    {
        $this->soireeService = $soireeService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        $idSoiree = $args['id'];

        $data = json_decode($rq->getBody(), true);
        $nbplaces = $data['nbplaces'] ?? null;

        try {
            if (!is_int($nbplaces) || $nbplaces <= 0) {
                throw new \InvalidArgumentException("Le nombre de places doit être un entier positif.");
            }


            $this->soireeService->updateAvailablePlaces($idSoiree, $nbplaces);

            $rs->getBody()->write(json_encode(['success' => 'Nombre de places mis à jour avec succès.']));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\InvalidArgumentException $e) {
            $rs->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['error' => 'Erreur interne du serveur']));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
