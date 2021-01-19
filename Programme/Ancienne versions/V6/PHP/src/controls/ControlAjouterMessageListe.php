<?php

declare(strict_types=1);

namespace mywishlist\controls;

use mywishlist\models\Message;
use mywishlist\vue\VueAjoutMessage;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \mywishlist\models\Liste;

class ControlAjouterMessageListe{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    //permet de recupere les informations pour creer l'item
    public function ajoutMessageliste(Request $rq, Response $rs, $args) : Response {
        $vue = new VueAjoutMessage( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render(  1) ) ;
        return $rs;
    }


    //Ajout d'un message sur une liste publique
    public function newMessage(Request $rq, Response $rs, array $args): Response {
        session_start();
        $post = $rq->getParsedBody() ;

        $auteur = filter_var($post['auteur'], FILTER_SANITIZE_STRING);
        $message = filter_var($post['message'], FILTER_SANITIZE_STRING);

        $m = new message();
        $m->liste_id = $_SESSION['no'];
        $m->msg = $message;
        $m->auteur = $auteur;
        $m->save();

        $url_items = $this->container->router->pathFor( 'aff_liste', ['token' => $_SESSION['token']] ) ;
        return $rs->withRedirect($url_items);


    }

}