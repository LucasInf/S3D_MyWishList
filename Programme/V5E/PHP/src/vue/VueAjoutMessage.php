<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueAjoutMessage
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function formListe() : string {
        $url_new_liste = $this->container->router->pathFor( 'ajoutMessageListe' ) ;
        $html = <<<FIN
<form method="POST" action="$url_new_liste">
	<label>Auteur:<br> <input type="text" name="auteur"/></label><br>
	<label>Description: <br><input type="text" name="message"/></label><br>
	<button type="submit">Envoyer Message</button>
</form>
FIN;
        return $html;
    }

    public function render( int $select ) : string {

        switch ($select) {
            case 1 : {
                $content = $this->formListe();
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
				<li><a href="$url_testform">S'inscrire</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}