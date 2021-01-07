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
        $rs->getBody()->write( $vue->render( 2 ) ) ;
        return $rs;
    }


	
	
}