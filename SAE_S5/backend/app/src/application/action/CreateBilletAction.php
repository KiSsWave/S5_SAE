<?php

namespace nrv\application\action;

use http\Client\Response;
use nrv\core\services\Soiree\SoireeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;

class CreateBilletAction extends AbstractAction
{
    private SoireeService $soireeService;

    public function __construct(SoireeService $soireeService)
    {
        $this->soireeService = $soireeService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        $queryParams = $rq->getQueryParams();

        $id_acheteur = $queryParams['id_user'] ?? null;
        $reference = $queryParams['reference'] ?? null;
        $nomAcheteur = $queryParams['nomAcheteur'] ?? null;
        $dateHoraireSoiree = $queryParams['dateHoraireSoiree'] ?? null;
        $prix = isset($queryParams['prix']) ? (int)$queryParams['prix'] : null;
        $typeTarif = $queryParams['typeTarif'] ?? null;

        $data = [
            'id_user' => $id_acheteur,
            'reference' => $reference,
            'nomAcheteur' => $nomAcheteur,
            'dateHoraireSoiree' => $dateHoraireSoiree,
            'prix' => $prix,
            'typeTarif' => $typeTarif
        ];

        if (in_array(null, $data, true)) {
            throw new HttpBadRequestException($rq, 'Données manquantes.');
        }

        $this->soireeService->creationBillet($data);

        $rs->getBody()->write(json_encode(['message' => 'Billet créé avec succès.']));
        return $rs->withHeader('Content-Type', 'application/json')->withStatus(201);

    }
}




