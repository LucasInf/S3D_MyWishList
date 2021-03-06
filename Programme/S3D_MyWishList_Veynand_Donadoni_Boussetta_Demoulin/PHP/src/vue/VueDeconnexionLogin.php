<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueDeconnexionLogin
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    //permet de demander la deconnexion
    private function deconnexion() : string {
        $url_deconnexion = $this->container->router->pathFor( 'deconnexion' ) ;
        $html = <<<FIN
<form method="POST" action="$url_deconnexion">
	<label>Etes vous sur de vouloir vous deconnecter ?<br> </label><br>
	<button type="submit">Deconnexion</button>
</form>
FIN;
        return $html;
    }

    private function deconnecter() : string {
        $url_deconnexion = $this->container->router->pathFor( 'racine' ) ;
        $html = <<<FIN
<form method="GET" action="$url_deconnexion">
	<h2>Vous etes bien deconnecté<br> </h2>
	<button type="submit">Retourner à l'accueil</button>
</form>
FIN;
        return $html;
    }

    public function render( int $select ) : string {

        switch ($select) {

            case 1 : {
                $content = $this->deconnexion();
                break;
            }
            case 2 : {
                $content = $this->deconnecter();
                break;
            }


        }
        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;
        $url_voslistes     = $this->container->router->pathFor( 'aff_voslistes'             ) ;
        $url_form_liste = $this->container->router->pathFor( 'formListe'              ) ;
        $url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;
        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;
        $url_listesCr = $this->container->router->pathFor( 'aff_createur'             ) ;
        $url_compte     = $this->container->router->pathFor( 'aff_compte'             ) ;


        if(isset($_SESSION['login'])) {
            $ada = "<li><a href=".$url_voslistes.">Vos Listes</a></li>
				<li><a href=".$url_form_liste.">Nouvelle Liste</a></li>
                <li><a href=".$url_compte.">Mon compte</a></li>";
        }else{
            $ada = "<li><a href=".$url_formlogin.">S'inscrire</a></li>
			<li><a href=".$url_testform.">Se connecter</a></li>";


        }
        $html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../CSS/design.css" />
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
