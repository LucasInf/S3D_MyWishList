<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueCreationListe
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function formListe() : string {
        $url_new_liste = $this->container->router->pathFor( 'newListe' ) ;
        $html = <<<FIN
<form method="POST" action="$url_new_liste">
	<label>Titre:<br> <input type="text" name="titre"/></label><br>
	<label>Description: <br><input type="text" name="description"/></label><br>
	<button type="submit">Enregistrer la liste</button>
</form>
FIN;
        return $html;
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

    private function choixdeleteListe() : string {
        $url_deleteListe = $this->container->router->pathFor( 'deleteListe' ) ;
        $html = <<<FIN
<form method="POST" action="$url_deleteListe">
    <label>Titre:<br> <input type="text" name="nom"/></label><br>
    <label>Token:<br> <input type="text" name="token"/></label><br>
	<button type="submit">Supprimer la liste</button>
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
            case 2 : {
                $content = $this->choixmodifyListe();
                break;
            }
            case 3 : {
                $content = $this->choixdeleteListe();
                break;
            }
        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;
        $url_form_liste = $this->container->router->pathFor( 'formListe'              ) ;
        $url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;
        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;
        $url_choixmodifyListe   = $this->container->router->pathFor( 'choixmodifyListe'               ) ;
        $url_choixdeleteListe   = $this->container->router->pathFor( 'choixdeleteListe'               ) ;

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
        <li><a href="$url_choixmodifyListe">Modifier la liste</a></li>
				<li><a href="$url_choixdeleteListe">Supprimer la liste</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}
