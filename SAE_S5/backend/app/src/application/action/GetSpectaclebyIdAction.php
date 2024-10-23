<?php

namespace nrv\application\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\services\Spectacle\SpectacleServiceInterface;

class GetSpectaclebyIdAction extends AbstractAction
{
    private SpectacleServiceInterface $spectacleService;

    public function __construct(SpectacleServiceInterface $s)
    {
        $this->spectacleService = $s;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        $spectacle_id = $args["ID-SPECTACLE"];

        try {
            $spectacle = $this->spectacleService->afficherSpectacle($spectacle_id);

            $soiree_tab = $this->spectacleService->afficherSoireesParSpectacleID($spectacle->ID);

            $soireeAssociee = [];
            foreach ($soiree_tab as $s) {
                $soireeAssociee[] = [
                    "idSoiree" => $s->idSoiree,
                    "href" => "/soiree/" . $s->idSoiree
                ];
            }

            $artistes_tab = $this->spectacleService->afficherArtistesParSpectacleID($spectacle->ID);
            $artistes = [];
            foreach ($artistes_tab as $a){
                $artistes[] = [
                    "Pseudonyme" => $a->pseudonyme,
                    "Nom" => $a->nom,
                    "Prenom" => $a->prenom
                ];
            }


            $resultat = ["Spectacle" => [
                "Titre" => $spectacle->titre,
                "Description" => $spectacle->description,
                "Style" => $spectacle->style,
                "Date" => $spectacle->horaire->format('Y-m-d'),
                "Horaire" => $spectacle->horaire->format('H:i'),
                "Video" => $spectacle->urlVideo,
                "Images" => $spectacle->images,
                "Artistes" => $artistes,
                ],
                "links" => [
                    "self" => [
                        "href" => "/spectacle/" . $spectacle->ID
                    ]
                ],
                "Soiree" => $soireeAssociee
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
