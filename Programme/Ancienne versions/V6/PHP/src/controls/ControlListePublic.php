<?php

declare(strict_types=1);

namespace mywishlist\controls;

use mywishlist\models\Liste;
use mywishlist\vue\VueListePublic;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class ControlListePublic
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    //permet de recupere les informations pour creer la liste
    public function verifPublic(Request $rq, Response $rs, $args) : Response {
        // pour afficher le formulaire liste
        $vue = new VueListePublic( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 1 ) ) ;
        return $rs;
    }

    //creer une liste
    public function passagePublic(Request $rq, Response $rs, $args) : Response {
        // pour enregistrer 1 liste.....
        session_start();
        $no = $_SESSION['no'];
        $l = Liste::where( 'no', '=', $no)->first() ;
        $l->public= !$l->public;
        $l->update();

        $url_listes = $this->container->router->pathFor( 'aff_liste', ['token' => $_SESSION['token']] ) ;
        return $rs->withRedirect($url_listes);

    }
}