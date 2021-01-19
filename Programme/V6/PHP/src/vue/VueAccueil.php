<?php
declare(strict_types=1);

namespace mywishlist\vue;
use \mywishlist\models\User;

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
				$content = '<h2>accueil racine du site</h2>';
                session_start();
                if (isset($_SESSION['login'])) {
                    $nom = User::where('id', '=', $_SESSION['login'])->first();
                    $content .= "<h3>Bonjour {$nom['login']}</h3>";
                }
				break;
			}
		}

		$url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
		$url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;
        $url_voslistes     = $this->container->router->pathFor( 'aff_voslistes'             ) ;
		$url_form_liste = $this->container->router->pathFor( 'formListe'              ) ;
		$url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;
		$url_testform   = $this->container->router->pathFor( 'testform'               ) ;
        $url_deconnexion   = $this->container->router->pathFor( 'deconnexion'               ) ;

if(isset($_SESSION['login'])){
    $html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="CSS/design.css" />
    <title>Exemple</title>
  </head>
  <body>
		<h1><a href="$url_accueil">Wish List</a></h1>
		<nav>
			<ul>
				<li><a href="$url_accueil">Accueil</a></li>
				<li><a href="$url_listes">Listes</a></li>
				<li><a href="$url_voslistes">Vos Listes</a></li>
				<li><a href="$url_form_liste">Nouvelle Liste</a></li>
				<li><a href="$url_deconnexion">Deconnexion</a></li>
				
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
}else{
    $html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="CSS/design.css" />
    <title>Exemple</title>
  </head>
  <body>
		<h1><a href="$url_accueil">Wish List</a></h1>
		<nav>
			<ul>
			    <li><a href="$url_accueil">Accueil</a></li>
			    <li><a href="$url_listes">Listes</a></li>
				<li><a href="$url_formlogin">S'inscrire</a></li>
				<li><a href="$url_testform">Se connecter</a></li>
				
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
}

		return $html;
	}
}
