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
        session_start();
        $html = <<<FIN
    <form method="POST" action="$url_modifyListe">
    <h2>Modifier la liste "{$_SESSION['titre']}" ?</h2>
    <label>Nouveau titre:<br> <input type="text" name="nouveautitre"/></label><br>
    <label>Nouvelle description:<br> <input type="text" name="nouvelledescription"/></label><br>
    <label>Date d'échéance: <br><input type="date" name="nouvelleecheance"/></label><br>
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
        $url_voslistes     = $this->container->router->pathFor( 'aff_voslistes'             ) ;
        $url_form_liste = $this->container->router->pathFor( 'formListe'              ) ;
        $url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;
        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;
        $url_deconnexion   = $this->container->router->pathFor( 'deconnexion'               ) ;
        $url_listesCr = $this->container->router->pathFor( 'aff_createur'             ) ;


        if(isset($_SESSION['login'])) {
            $ada = "<li><a href=".$url_voslistes.">Vos Listes</a></li>
				<li><a href=".$url_form_liste.">Nouvelle Liste</a></li>
				<li><a href=".$url_deconnexion.">Deconnexion</a></li>";
        }else{
            $ada = "<li><a href=".$url_formlogin.">S'inscrire</a></li>
			<li><a href=".$url_testform.">Se connecter</a></li>";

        }
        $html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../../CSS/design.css" />
    <title>Exemple</title>
  </head>
  <body>
		<h1><a href="$url_accueil">Wish List</a></h1>
		<nav>
			<ul>
				<li><a href="$url_accueil">Accueil</a></li>
				<li><a href="$url_listes">Listes</a></li>
				<li><a href="$url_listesCr">Liste créateur</a></li>
				$ada

			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}
