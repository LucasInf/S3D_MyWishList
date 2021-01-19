<?php
declare(strict_types=1);

namespace mywishlist\controls;


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueAccueil;

class ControlAccueil {
	private $container;
	
	public function __construct($container) {
		$this->container = $container;
	}
	public function accueil(Request $rq, Response $rs, $args) : Response {
		$vue = new VueAccueil( [] , $this->container ) ;
		$rs->getBody()->write( $vue->render( 0 ) ) ;
		return $rs;
	}
	
}