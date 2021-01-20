<?php
declare(strict_types=1);

namespace mywishlist\vue;

use mywishlist\models\Item;


class VueAffichageListes
{
    private $tab;
    private $container;

    public function __construct($tab, $container)
    {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function lesListes(): string
    {
        $html = '';
        $html .= "<h2>Les Wish Listes public:</h2>";
        foreach ($this->tab as $liste) {
            if ($liste['public'] == true && $liste['expiration'] >= date('Y-m-d')){
                $url_liste = $this->container->router->pathFor('aff_liste', ['token' => $liste['token']]);
                $html .= "<li><a href='$url_liste'>{$liste['titre']}</a></li>";
            }

        }
        $html = "<ul>$html</ul>";
        return $html;
    }

    public function render( int $select ) : string
    {

        switch ($select) {
            case 1 :
            { // liste des listes
                $content = $this->lesListes();
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

session_start();
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
