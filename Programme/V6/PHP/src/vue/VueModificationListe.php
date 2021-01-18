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
        $l = $this->tab[0];

        $url_modifyListe = $this->container->router->pathFor( 'modifyListe' ) ;
        session_start();
        $html = <<<FIN
    <form method="POST" action="$url_modifyListe">
    <h2>Modifier la liste "{$_SESSION['titre']}" ?</h2>
    <label>Nouveau titre:<br> <input type="text" name="nouveautitre"/></label><br>
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
        $url_deconnexion   = $this->container->router->pathFor( 'deconnexion'               ) ;


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
				<li><a href="$url_deconnexion">Deconnexion</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}
