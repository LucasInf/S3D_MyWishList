<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueModifyLogin
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function choixmodifylogin() : string {
        session_start();
        $url_modifylogin = $this->container->router->pathFor( 'modifylogin' ) ;
        $html = <<<FIN
<form method="POST" action="$url_modifylogin">
	<h2>Etes vous sur de vouloir modifier votre compte ?</h2>
	<label>Rentrez votre mot de passe: <br><input type="text" name="pass"/></label><br>
	<label>Nouveau mot de passe: <br><input type="text" name="Npass"/></label><br>
	<button type="submit">Modifier le login</button>
</form>
FIN;
        return $html;
    }


    public function render( int $select ) : string {

        switch ($select) {
            case 1 : {
                $content = $this->choixmodifylogin();
                break;
            }

        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;
        $url_form_liste = $this->container->router->pathFor( 'formListe'              ) ;
        $url_choixmodifylogin  = $this->container->router->pathFor( 'choixmodifylogin'              ) ;
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
				<li><a href="$url_listes">Listes</a></li>
				<li><a href="$url_form_liste">Nouvelle Liste</a></li>
				<li><a href="$url_choixmodifylogin">Modifier un compte</a></li>
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
