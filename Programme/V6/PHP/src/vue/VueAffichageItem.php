<?php
declare(strict_types=1);

namespace mywishlist\vue;
use mywishlist\models\Liste;

class VueAffichageItem
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }


    private function unItem() : string {
        session_start();
        $i = $this->tab[0];

        $url_choixdeleteItem   = $this->container->router->pathFor( 'choixdeleteItem',    ['id' => $i['id']]         ) ;
        $url_choixmodifyItem   = $this->container->router->pathFor( 'choixmodifyItem',    ['id' => $i['id']]         ) ;

        $html = "<h2>ITEM : {$i['nom']}</h2>";
        $html .= "<p><img src={$i['img']}></p>";
        $html .= "<b>Description:</b> {$i['descr']}<br>";
        $html .= "<b>Tarif:</b> {$i['tarif']}<br>";
        $liste= Liste::where('no','=',$i['liste_id'])->first();
        if($liste['user_id']==$_SESSION['login']) {
            $html .= "<a href='$url_choixmodifyItem'>Modifier</a><br>";
            $html .= "<a href='$url_choixdeleteItem'>Supprimer</a><br>";
        }


        return $html;
    }


    public function render( int $select ) : string {

        switch ($select) {
            case 2 : { // un item
                $content = $this->unItem();
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
    <link rel="stylesheet" href="../CSS/design.css" />
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
