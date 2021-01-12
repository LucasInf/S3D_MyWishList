<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueAffichageListe;
use \mywishlist\models\Liste;

class ControlAffichageListe
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function afficherListes(Request $rq, Response $rs, $args) : Response {
        // pour afficher la liste des listes de souhaits
        $listl = Liste::all() ;
        $vue = new VueAffichageListe( $listl->toArray() , $this->container ) ;
        $rs->getBody()->write( $vue->render( 1 ) ) ;
        return $rs;
    }

    public function afficherListe(Request $rq, Response $rs, $args) : Response {
        $liste = Liste::find( $args['no'] ) ;
        $vue = new VueAffichageListe( [ $liste->toArray() ] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 2 ) ) ;
        return $rs;
    }
}