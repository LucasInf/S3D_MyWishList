<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueSupLogin
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function choixsuplogin() : string {
        session_start();
        $url_suplogin = $this->container->router->pathFor( 'suplogin' ) ;
        $html = <<<FIN
<form method="POST" action="$url_suplogin">
	<label>Login:<br> {$_SESSION['login']}</label><br>
	<label>Mot de passe: <br><input type="text" name="pass"/></label><br>
	<button type="submit">Supprimer le login</button>
</form>
FIN;
        return $html;
    }


    public function render( int $select ) : string {

        switch ($select) {
            case 1 : {
                $content = $this->choixsuplogin();
                break;
            }

        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;
        $url_form_liste = $this->container->router->pathFor( 'formListe'              ) ;
        $url_choixsuplogin  = $this->container->router->pathFor( 'choixsuplogin'              ) ;
        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;

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
				<li><a href="$url_listes">Listes</a></li>
				<li><a href="$url_form_liste">Nouvelle Liste</a></li>
				<li><a href="$url_choixsuplogin">Supprimer un compte</a></li>
				<li><a href="$url_testform">Se connecter</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}
