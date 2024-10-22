<?php

namespace nrv\core\domain\entities\Spectacle;

use DateTime;
use nrv\core\domain\entities\Entity;

class Spectacle extends Entity
{
    protected string $titre;
    protected string $description;
    protected array $images;
    protected string $url;
    protected string $style;
    protected DateTime $horaire;

    public function __construct(string $t, string $d, string $image, string $u, string $s, DateTime $h){
        $this->titre = $t;
        $this->description = $d;
        $this->images[] = $image;
        $this->url= $u;
        $this->style = $s;
        $this->horaire = $h;
    }

}