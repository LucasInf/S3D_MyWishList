<?php
declare(strict_types=1);

namespace mywishlist\vue;
use mywishlist\models\Liste;
use mywishlist\models\Reservation;
use mywishlist\models\User;
use function Sodium\add;

class VueAffichageCompte
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }



    private function monCompte() : string {
        session_start();
        $user = User::where('id','=',$_SESSION['login'])->first();
        $url_choixmodifylogin  = $this->container->router->pathFor( 'choixmodifylogin'              ) ;
        $url_choixsuplogin  = $this->container->router->pathFor( 'choixsuplogin'              ) ;
        $url_deconnexion   = $this->container->router->pathFor( 'deconnexion'               ) ;
        $html = "<h2>MON COMPTE :</h2>";


        $html .= "<strong>login: {$user['login']}</strong><br><br>";
        $html .= "<b><a href=$url_choixmodifylogin>Modifier mon compte</a></b><br>";
        $html .= "<b><a href=$url_choixsuplogin>Supprimer mon compte</a></b><br>";
        $html .= "<b><a href=$url_deconnexion>Deconnecter de mon compte</a></b><br>";


        return $html;
    }


    public function render( int $select ) : string {

        switch ($select) {
            case 1 : { // un item
                $content = $this->monCompte();
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
