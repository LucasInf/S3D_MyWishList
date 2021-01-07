<?php
declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \mywishlist\vue\VueWish;
use \mywishlist\models\Liste;

class MonControleur {
	private $container;

	public function __construct($container) {
		$this->container = $container;
	}
	public function accueil(Request $rq, Response $rs, $args) : Response {
		$vue = new VueWish( [] , $this->container ) ;
		$rs->getBody()->write( $vue->render( 0 ) ) ;
		return $rs;
	}
	public function afficherListes(Request $rq, Response $rs, $args) : Response {
		// pour afficher la liste des listes de souhaits
		$listl = Liste::all() ;
		$vue = new VueWish( $listl->toArray() , $this->container ) ;
		$rs->getBody()->write( $vue->render( 1 ) ) ;
		return $rs;
	}

    public function afficherListe(Request $rq, Response $rs, $args) : Response {
        $liste = Liste::find( $args['no'] ) ;
        $vue = new VueWish( [ $liste->toArray() ] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 3 ) ) ;
        return $rs;
    }

		public function formListe(Request $rq, Response $rs, $args) : Response {
        // pour afficher le formulaire liste
        $vue = new VueWish( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 2 ) ) ;
        return $rs;
    }

		public function newListe(Request $rq, Response $rs, $args) : Response {
        // pour enregistrer 1 liste.....
        $post = $rq->getParsedBody() ;
        $titre       = filter_var($post['titre']       , FILTER_SANITIZE_STRING) ;
        $description = filter_var($post['description'] , FILTER_SANITIZE_STRING) ;
        $l = new Liste();
        $l->titre = $titre;
        $l->description = $description;
        $l->save();

        $url_listes = $this->container->router->pathFor( 'aff_listes' ) ;
        return $rs->withRedirect($url_listes);

        //$listl = Liste::all() ;
        //$vue = new VueWish( $listl->toArray() , $this->container ) ;
        //$rs->getBody()->write( $vue->render( 1 ) ) ;
        //return $rs;
    }

		public function modifyListe(Request $rq, Response $rs, $args): Response{
        $post = $rq->getParsedBody() ;
        $token   = filter_var($post['token']       , FILTER_SANITIZE_NUMBER_INT) ;
        $titre    = filter_var($post['nom']       , FILTER_SANITIZE_STRING) ;
        $i = Liste::where( 'titre', 'LIKE', $titre, 'AND', 'AND', 'token', 'LIKE', $token  )->first() ;
        $newD = filter_var($_POST['nouvelledescription'],FILTER_SANITIZE_STRING);
        $i->description = $newD;
        $i->update();
        $url_listes = $this->container->router->pathFor( 'aff_listes' ) ;
        return $rs->withRedirect($url_listes);

    }

    public function choixmodifyListe(Request $rq, Response $rs, $args): Response{
        $vue = new VueWish([], $this->container);
        $rs->getBody()->write($vue->render(4));
        return $rs;
    }




}
