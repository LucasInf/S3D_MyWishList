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
        $html .= "<h2>Les Wish Listes :</h2>";
        foreach ($this->tab as $liste) {
            $url_liste = $this->container->router->pathFor('aff_liste', ['token' => $liste['token']]);
            $html .= "<li><a href='$url_liste'>{$liste['titre']}</a>, {$liste['description']}</li>";
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
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}