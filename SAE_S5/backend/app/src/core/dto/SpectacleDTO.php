<?php

namespace nrv\core\dto;

use Faker\Core\DateTime;
use Spectacle\Spectacle;
use nrv\core\dto\DTO;

class SpectacleDTO extends DTO{
    protected string $ID;
    protected string $titre;
    protected string $description;

    protected array $images;
    protected string $urlVideo;
    protected string $style;
    protected DateTime $horaire;

    public function __construct(Spectacle $s){
        $this->ID = $s->getID();
        $this->titre = $s->titre;
        $this->description = $s->description;
        $this->images = $s->images;
        $this->urlVideo = $s->urlVideo;
        $this->style = $s->style;
        $this->horaire = $s->horaire;
    }




}
