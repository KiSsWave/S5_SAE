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

        $titre = isset($data['titre']) && is_string($data['titre']) && strlen($data['titre']) <= 255 ? $data['titre'] : null;
        $descripton = isset($data['description']) && is_string($data['description']) ? $data['description'] : null;
        $images = isset($data['images']) && is_array($data['images']) ? $data['images'] : null;
        $url = isset($data['urlVideo']) && filter_var($data['urlVideo'], FILTER_VALIDATE_URL) ? $data['urlVideo'] : null;
        $style = isset($data['style']) && is_string($data['style']) ? $data['style'] : null;
        $horaire = isset($data['horaire']);

        if (!$titre || !$descripton || !$style || !$horaire) {
            $rs->getBody()->write(json_encode(['error' => 'Certains champs obligatoires sont manquants ou invalides']));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(400);
        }


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