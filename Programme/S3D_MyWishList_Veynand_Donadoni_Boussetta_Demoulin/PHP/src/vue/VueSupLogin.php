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
	<h2>Etes vous sur de vouloir supprimer votre compte ?</h2>
	<label>Rentrez votre mot de passe: <br><input type="text" name="pass"/></label><br>
	<button type="submit">Supprimer le login</button>
</form>
FIN;
        return $html;
    }


    public function render( int $select ) : string {

        switch ($select) {
            case 0 : {
                $content = '<h2>Compte supprimé avec succès</h2>';
                break;
            }
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
    <link rel="stylesheet" href="../../CSS/design.css" />
  </head>
  <body>
		<h1><a href="$url_accueil">Wish List</a></h1>
		<nav>
			<ul>
				<li><a href="$url_accueil">Accueil</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}
