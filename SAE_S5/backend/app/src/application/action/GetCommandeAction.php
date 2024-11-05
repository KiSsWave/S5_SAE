<?php

namespace nrv\application\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\services\Soiree\SoireeServiceInterface;

class GetCommandeAction extends AbstractAction
{
    private SoireeServiceInterface $soireeService;

    public function __construct(SoireeServiceInterface $soireeService)
    {
        $this->soireeService = $soireeService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $user = $rq->getAttribute('auth');
        $iduser = $user->id;

        $resultat = [
            'Commandes' => []
        ];

        try {

            $commandes = $this->soireeService->recuperationCommandesByUser($iduser);

            foreach ($commandes as $command) {
                $tarif = 0;
                if($command->typetarif == "tarif"){
                    $tarif = $this->soireeService->afficherSoiree($command->idsoiree)->tarif*$command->placesvendues;
                } else {
                    $tarif = $this->soireeService->afficherSoiree($command->idsoiree)->tarifReduit*$command->placesvendues;
                }

                $resultat['Commandes'][] = [
                    "iduser" => $command->iduser,
                    "Reference" => $command->idsoiree,
                    "Date" => $command->date_achat->format('Y-m-d H:i'),
                    "Places" => $command->placesvendues,
                    "TypeTarif" => $command->typetarif,
                    "prix" => $tarif,
                ];
            }

            if (empty($commandes)) {
                return $rs->withHeader('Content-Type', 'application/json')->withStatus(204); // No content
            }

            $rs->getBody()->write(json_encode($commandes));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['error' => 'Erreur interne du serveur']));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
