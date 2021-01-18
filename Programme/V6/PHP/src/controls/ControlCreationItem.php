<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueCreationItem;
use \mywishlist\models\Item;

class ControlCreationItem
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    //permet de recupere les informations pour creer l'item
    public function formItem(Request $rq, Response $rs, $args) : Response {
        // pour afficher le formulaire item
        $vue = new VueCreationItem( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 1 ) ) ;
        return $rs;
    }

    //creer un item
    public function newItem(Request $rq, Response $rs, $args) : Response {
        // pour enregistrer 1 item.....
        session_start();
        $post = $rq->getParsedBody() ;
        $liste_id    = $_SESSION['no'] ;
        $nom     = filter_var($post['nom']       , FILTER_SANITIZE_STRING) ;
        $descr = filter_var($post['descr'] , FILTER_SANITIZE_STRING) ;
        $tarif = filter_var($post['tarif'] , FILTER_SANITIZE_NUMBER_INT) ;
        $l = new Item();
        $l->liste_id = $liste_id;
        $l->nom = $nom;
        $l->descr = $descr;
        $l->tarif = $tarif;
        $l->save();

        $url_items = $this->container->router->pathFor( 'aff_liste', ['token' => $_SESSION['token']] ) ;
        return $rs->withRedirect($url_items);

    }
}
