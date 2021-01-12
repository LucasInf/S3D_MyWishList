<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueAffichageListe
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function lesListes() : string {
        $html = '';
        foreach($this->tab as $liste){
            $url_liste   = $this->container->router->pathFor( 'aff_liste', ['no' => $liste['no']] ) ;
            $html .= "<li><a href='$url_liste'>{$liste['titre']}</a>, {$liste['description']}</li>";
        }
        $html = "<ul>$html</ul>";
        return $html;
    }

    private function uneListe() : string {
        $l = $this->tab[0];
        $url_share = $this->container->router->pathFor( 'share', ['no' => $l['no']] ) ;
        $url_msg = $this->container->router->pathFor( 'ajoutMessageliste', ['no' => $l['no']] ) ;
        $html = "<h2>Liste {$l['no']}</h2>";
        $html .= "<b>Titre:</b> {$l['titre']}<br>";
        $html .= "<b>Description:</b> {$l['description']}<br>";
        $html .= "<a href='$url_msg'>Ajouter un message</a><br>";
        $html .= "<a href='$url_share'>Partager</a>";
        return $html;
    }


    public function render( int $select ) : string {

        switch ($select) {
            case 1 : { // liste des listes
                $content = $this->lesListes();
                break;
            }
            case 2 : {
                $content = $this->uneListe();
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