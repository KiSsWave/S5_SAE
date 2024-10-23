<?php

namespace nrv\application\action;

use nrv\core\services\Soiree\SoireeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

class CreateBilletAction
{
    private SoireeService $soireeService;

    public function __construct(SoireeService $soireeService)
    {
        $this->soireeService = $soireeService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $params = $request->getQueryParams();
        // Assurez-vous que tous les paramètres requis sont présents
        $requiredParams = ['id_user', 'reference', 'nomAcheteur', 'dateHoraireSoiree', 'typeTarif', 'prix'];
        foreach ($requiredParams as $param) {
            if (!isset($params[$param])) {
                return $response->withStatus(400)->withBody("Données manquantes.");
            }
        }


        $billetData = $this->soireeService->creationBillet($params);


        $response->getBody()->write(json_encode($billetData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
}





