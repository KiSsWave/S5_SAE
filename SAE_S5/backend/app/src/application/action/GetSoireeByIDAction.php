<?php

namespace nrv\application\action;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\services\Soiree\SoireeServiceInterface;

class GetSoireeByIDAction extends AbstractAction
{
    private SoireeServiceInterface $soireeService;

    public function __construct(SoireeServiceInterface $s){
        $this->soireeService = $s;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $soiree_id = $args['ID-SOIREE'];

        try{
            $soiree = $this->soireeService->afficherSoiree($soiree_id);
            $spectacles = $this->soireeService->afficherSpectaclesSoiree($soiree_id);
            $idSpectacles = [];
            foreach ($spectacles as $s){

                $idSpectacles[] = "/spectacle/" . $s->idSpectacle;

            }
            $resultat = ["Soiree" => [
                "NomSoiree" => $soiree->nom,
                "Thematique" => $soiree->thematique,
                "Date" => $soiree->dateSoiree->format('Y-m-d'),
                "Horaire" => $soiree->dateSoiree->format('H:i'),
                "Lieu" => $soiree->lieuSoiree,
                "Tarif" => $soiree->tarif,
                "TarifReduit" => $soiree->tarifReduit,
                "Spectacles" => $idSpectacles
            ],
                "links" => [
                    "self" => [
                        "href" => "/soiree/" . $soiree->ID
                    ]
                ],
            ];
            $rs->getBody()->write(json_encode($resultat));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        }catch (\Exception $e){
            $rs->getBody()->write(json_encode(['error' => 'Rendez-vous non trouvé']));

            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
    }
}