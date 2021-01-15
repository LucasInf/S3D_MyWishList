<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueModificationListe
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function choixmodifyListe() : string {
        $url_modifyListe = $this->container->router->pathFor( 'modifyListe' ) ;
        $html = <<<FIN
<form method="POST" action="$url_modifyListe">
    <label>Titre:<br> <input type="text" name="nom"/></label><br>
    <label>Token:<br> <input type="text" name="token"/></label><br>
    <label>Nouvelle description:<br> <input type="text" name="nouvelledescription"/></label><br>
    <button type="submit">Modifier la liste</button>
</form>
FIN;
        return $html;
    }

    public function render( int $select ) : string {

        switch ($select) {
            case 1 : {
                $content = $this->choixmodifyListe();
                break;
            }
        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;
        $url_form_liste = $this->container->router->pathFor( 'formListe'              ) ;
        $url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;
        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;
        $url_deconnexion   = $this->container->router->pathFor( 'deconnexion'               ) ;
        $url_choixdeleteListe   = $this->container->router->pathFor( 'choixdeleteListe'               ) ;
        $url_choixmodifyListe   = $this->container->router->pathFor( 'choixmodifyListe'               ) ;

        $html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
    <title>Exemple</title>
    <link rel="stylesheet" href="CSS/design.css" />
  </head>
  <body>
		<h1><a href="$url_accueil">Wish List</a></h1>
		<nav>
			<ul>
				<li><a href="$url_accueil">Accueil</a></li>
				<li><a href="$url_listes">Listes</a></li>
				<li><a href="$url_form_liste">Nouvelle Liste</a></li>
				<li><a href="$url_deconnexion">Deconnexion</a></li>
				<li><a href="$url_choixmodifyListe">Modifier une liste</a></li>
				<li><a href="$url_formlogin">Nouveau login</a></li>
				<li><a href="$url_testform">S'inscrire</a></li>
				<li><a href="$url_deconnexion">Deconnexion</a></li>
				<li><a href="$url_choixdeleteListe">Supprimer une liste</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}
