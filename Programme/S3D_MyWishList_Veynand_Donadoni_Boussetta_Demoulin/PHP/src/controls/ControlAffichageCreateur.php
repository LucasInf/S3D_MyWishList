<?php

declare(strict_types=1);

namespace mywishlist\controls;

use mywishlist\models\Liste;
use mywishlist\models\User;
use mywishlist\vue\VueAffichageCreateur;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueAffichageItem;
use \mywishlist\models\Item;

class ControlAffichageCreateur
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }



    public function afficherCreateur(Request $rq, Response $rs, $args) : Response {

        $vue = new VueAffichageCreateur( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 1 ) ) ;
        return $rs;
    }

}