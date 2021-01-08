<?php
declare(strict_types=1);

namespace mywishlist\vue;

class VueAccueil {

	private $tab; // tab array PHP
	private $container;

	public function __construct($tab, $container) {
		$this->tab = $tab;
		$this->container = $container;

	}

	public function render( int $select ) : string {

		switch ($select) {
			case 0 : {
				$content = 'accueil racine du site';
				break;
			}
		}


		$url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
		$url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;
		$url_form_liste = $this->container->router->pathFor( 'formListe'              ) ;
		$url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;
		$url_testform   = $this->container->router->pathFor( 'testform'               ) ;

		$html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
    <title>Exemple</title>
  </head>
  <body>
		<h1><a href="$url_accueil">Wish List</a></h1>
		<nav>
			<ul>
				<li><a href="$url_accueil">Accueil</a></li>
				<li><a href="$url_listes">Listes</a></li>
				<li><a href="$url_form_liste">Nouvelle Liste</a></li>
				<li><a href="$url_formlogin">Nouveau login</a></li>
				<li><a href="$url_testform">Test login</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
		return $html;
	}
}