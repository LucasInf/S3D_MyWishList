<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use mywishlist\vue\VueCreationItem;
use mywishlist\vue\VueCreationListe;
use \mywishlist\models\Liste;

class ControlCreationItem
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function afficherItems(Request $rq, Response $rs, $args) : Response {
        $items = Item::all() ;
        $vue = new VueWish( $items->toArray() , $this->container ) ;
        $rs->getBody()->write( $vue->render( 1 ) ) ;
        return $rs;
    }

    public function afficherItem(Request $rq, Response $rs, $args) : Response {
        $item = Item::find( $args['id'] ) ;
        $vue = new VueWish( [ $item->toArray() ] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 2 ) ) ;
        return $rs;
    }

    public function formItem(Request $rq, Response $rs, $args) : Response {
        // pour afficher le formulaire item
        $vue = new VueWish( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 3 ) ) ;
        return $rs;
    }

    public function newItem(Request $rq, Response $rs, $args) : Response {
        // pour enregistrer 1 item.....
        $post = $rq->getParsedBody() ;
        $liste_id    = filter_var($post['liste_id']       , FILTER_SANITIZE_NUMBER_INT) ;
        $nom     = filter_var($post['nom']       , FILTER_SANITIZE_STRING) ;
        $descr = filter_var($post['descr'] , FILTER_SANITIZE_STRING) ;
        $tarif = filter_var($post['tarif'] , FILTER_SANITIZE_NUMBER_INT) ;
        $l = new Item();
        $l->liste_id = $liste_id;
        $l->nom = $nom;
        $l->descr = $descr;
        $l->tarif = $tarif;
        $l->save();

        $url_items = $this->container->router->pathFor( 'aff_items' ) ;
        return $rs->withRedirect($url_items);

    }

    public function deleteItem(Request $rq, Response $rs, $args) : Response {
        // pour choisir 1 item.....
        $post = $rq->getParsedBody() ;
        $liste_id    = filter_var($post['liste_id']       , FILTER_SANITIZE_NUMBER_INT) ;
        $nom     = filter_var($post['nom']       , FILTER_SANITIZE_STRING) ;
        $descr = filter_var($post['descr'] , FILTER_SANITIZE_STRING) ;
        $tarif = filter_var($post['tarif'] , FILTER_SANITIZE_NUMBER_INT) ;
        $i = Item::where( 'nom', 'LIKE', $nom )->first() ;
        $i->delete();
        $url_items = $this->container->router->pathFor( 'aff_items' ) ;
        return $rs->withRedirect($url_items);
    }

    public function choixdeleteItem(Request $rq, Response $rs, $args): Response{
        $vue = new VueWish([], $this->container);
        $rs->getBody()->write($vue->render(6));
        return $rs;
    }

    public function modifyItem(Request $rq, Response $rs, $args): Response{
        $post = $rq->getParsedBody() ;
        $liste_id    = filter_var($post['liste_id']       , FILTER_SANITIZE_NUMBER_INT) ;
        $nom     = filter_var($post['nom']       , FILTER_SANITIZE_STRING) ;
        $descr = filter_var($post['descr'] , FILTER_SANITIZE_STRING) ;
        $tarif = filter_var($post['tarif'] , FILTER_SANITIZE_NUMBER_INT) ;
        $i = Item::where( 'nom', 'LIKE', $nom )->first() ;
        $newN = filter_var($_POST['nouveaunom'],FILTER_SANITIZE_STRING);
        $newD = filter_var($_POST['nouveaudescr'],FILTER_SANITIZE_STRING);
        $newT = filter_var($_POST['nouveautarif'],FILTER_SANITIZE_STRING);
        $i->nom = $newN;
        $i->descr = $newD;
        $i->tarif = $newT;
        $i->update();
        $url_items = $this->container->router->pathFor( 'aff_items' ) ;
        return $rs->withRedirect($url_items);

    }

    public function choixmodifyItem(Request $rq, Response $rs, $args): Response{
        $vue = new VueWish([], $this->container);
        $rs->getBody()->write($vue->render(7));
        return $rs;
    }
}
