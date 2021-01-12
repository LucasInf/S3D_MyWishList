<?php

declare(strict_types=1);

namespace mywishlist\controls;

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
        var_dump($args);
        $liste = Liste::find( $args['no'] ) ;
        var_dump($liste);
        $vue = new VueAjoutMessage( [ $liste->toArray() ] , $this->container ) ;
        $rs->getBody()->write( $vue->render(  1) ) ;
        return $rs;
    }


    //Ajout d'un message sur une liste publique
    public function newMessage(Request $rq, Response $rs, array $args): Response {
        try {
            $auteur = filter_var($rq->getParsedBodyParam('auteur'), FILTER_SANITIZE_STRING);
            $message = filter_var($rq->getParsedBodyParam('message'), FILER_SANITIZE_STRING);
            $token = filter_var(args('token'), FILER_SANITIZE_STRING);

            $liste = Liste::where('token', '=', $token)->firstOrFail();

            $this->loadCookiesFromRequest($rq);

            $message = new Message();
            $message->idListe = $liste->no;
            $message->message = $message;
            $message->auteur = $auteur;
            $message->save();

            $this->changeName($auteur);
            $rq = $this->createResponseCookie($rq);
            $this->flash->newMessage('Succes', "$auteur votre message à bien été envoyé");
            $rq = $rq->withRedirect($this->router->pathFor('aff_listes'));

        } catch (Exception $e) {
            $this->flash->newMessage('Error', $e->getMessage());
            $response = $rs->withRedirect($this->router->pathFor('aff_listes'));
        }

        return $rs;
    }

}