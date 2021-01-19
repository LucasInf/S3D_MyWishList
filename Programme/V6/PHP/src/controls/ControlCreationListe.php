<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueCreationListe;
use \mywishlist\models\Liste;

class ControlCreationListe
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    //permet de recupere les informations pour creer la liste
    public function formListe(Request $rq, Response $rs, $args) : Response {
        // pour afficher le formulaire liste
        $vue = new VueCreationListe( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 1 ) ) ;
        return $rs;
    }

    //creer une liste
    public function newListe(Request $rq, Response $rs, $args) : Response {
        // pour enregistrer 1 liste.....
        $post = $rq->getParsedBody() ;
        session_start();
        $titre       = filter_var($post['titre']       , FILTER_SANITIZE_STRING) ;
        $description = filter_var($post['description'] , FILTER_SANITIZE_STRING) ;
        $echeance = filter_var($post['echeance']) ;
        $token = openssl_random_pseudo_bytes(9);
        $token = bin2hex($token);
        $l = new Liste();
        $l->token = $token;
        if ($titre == "") $titre = 'Aucun nom';
        $l->titre = $titre;
        $l->user_id= $_SESSION['login'];
        $l->description = $description;
        $l->expiration=$echeance;
        $l->save();

        $url_listes = $this->container->router->pathFor( 'aff_listes' ) ;
        return $rs->withRedirect($url_listes);

    }
}