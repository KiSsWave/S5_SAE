<?php

namespace nrv\application\action;

use nrv\application\action\AbstractAction;
use nrv\core\services\Spectacle\SpectacleServiceInterface;
use nrv\infrastructure\repositories\SpectacleRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateSpectacleAction extends AbstractAction
{

    private SpectacleServiceInterface $spectacleService;

    public function __construct(SpectacleServiceInterface $spectacleService){
        $this->spectacleService = $spectacleService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();

        $titre = $data['titre'] ?? null;
        $descripton = $data['description'] ?? null;
        $images = $data['images'] ?? null;
        $url = $data['urlVideo'] ?? null;
        $style = $data['style'];
        $horaire = $data['horaire'];

        try{
            $this->spectacleService->ajouterSpectacle($titre,$descripton, $images, $url, $style, $horaire);

            return $rs->withHeader('Content-Type', 'application/json')->withStatus(201);
        }catch(\Exception $e){
            $rs->getBody()->write(json_encode(['error' => 'Erreur interne du serveur']));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
}