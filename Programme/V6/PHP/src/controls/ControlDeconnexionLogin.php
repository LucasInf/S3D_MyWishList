<?php

declare(strict_types=1);

namespace mywishlist\controls;


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueDeconnexionLogin;
use \mywishlist\models\User;

class ControlDeconnexionLogin
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    //permet de se deconnecter
    public function deconnexionVerif(Request $rq, Response $rs, $args) : Response {
        $vue = new VueDeconnexionLogin( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 1 ) ) ;
        return $rs;
    }

    //permet de se deconnecter
    public function deconnexion(Request $rq, Response $rs, $args) : Response {
        session_start();
        session_destroy();
        $vue = new VueDeconnexionLogin( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 2 ) ) ;
        return $rs;
    }

}