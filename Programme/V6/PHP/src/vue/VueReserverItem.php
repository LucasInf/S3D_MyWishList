<?php
declare(strict_types=1);

namespace mywishlist\vue;
use mywishlist\models\User;


class VueReserverItem
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function choixreserverItem() : string {

        $i = $this->tab[0];
        $url_reserverItem = $this->container->router->pathFor('reserverItem');
        session_start();
        $_SESSION['itemReserv'] = $i['id'];
        if(isset($_SESSION['login'])) {
            $html = <<<FIN
    <form method="POST" action="$url_reserverItem">
    <label>Nom participant:<br> {$_SESSION['login']}</label><br>
	<label>Liste ID:<br> {$_SESSION['listeReserv']}</label><br>
	<label>Id item:<br> {$i['id']} </label><br>
	<button type="submit">Reserver item</button>
</form>
FIN;
        }else{
            $html = <<<FIN
    <form method="POST" action="$url_reserverItem">
    <label>Nom participant:<br> <input type="text" name="nomP"/></label><br>
	<label>Liste ID:<br> {$_SESSION['listeReserv']}</label><br>
	<label>Id item:<br> {$i['id']} </label><br>
	<button type="submit">Reserver item</button>
</form>
FIN;
        }
        return $html;
    }

    public function render( int $select ) : string {

        switch ($select) {
            case 0 : {
                $content = $this->choixreserverItem();
                break;
            }
        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_deconnexion   = $this->container->router->pathFor( 'deconnexion'               ) ;
        $url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;
        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;


        if(isset($_SESSION['login'])) {
            $html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
    <title>Exemple</title>
    <link rel="stylesheet" href="../CSS/design.css" />
  </head>
  <body>
		<h1><a href="$url_accueil">Wish List</a></h1>
		<nav>
			<ul>
				<li><a href="$url_accueil">Accueil</a></li>
				<li><a href="$url_deconnexion">Deconnexion</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        }else {
            $html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
    <title>Exemple</title>
    <link rel="stylesheet" href="../CSS/design.css" />
  </head>
  <body>
		<h1><a href="$url_accueil">Wish List</a></h1>
		<nav>
			<ul>
				<li><a href="$url_accueil">Accueil</a></li>
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
