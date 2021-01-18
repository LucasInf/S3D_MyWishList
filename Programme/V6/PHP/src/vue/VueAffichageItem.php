<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueAffichageItem
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function lesItems() : string {
        $html = '';
        foreach($this->tab as $item){
            $url_item   = $this->container->router->pathFor( 'aff_item', ['id' => $item['id']] ) ;
            $html .= "<li><a href='$url_item'>{$item['nom']}</a>,{$item['descr']}, {$item['tarif']}</li>";
        }
        $html = "<ul>$html</ul>";
        return $html;
    }

    private function unItem() : string {
        $i = $this->tab[0];

        $url_choixdeleteItem   = $this->container->router->pathFor( 'choixdeleteItem',    ['id' => $i['id']]         ) ;

        $html = "<h2>Item {$i['id']}</h2>";
        $html .= "<b>Nom:</b> {$i['nom']}<br>";
        $html .= "<b>Descr:</b> {$i['descr']}<br>";
        $html .= "<b>Tarif:</b> {$i['tarif']}<br>";

        $html .= "<a href='$url_choixdeleteItem'>Supprimer</a><br>";


        return $html;
    }


    public function render( int $select ) : string {

        switch ($select) {
            case 1 : { // liste des items
                $content = $this->lesItems();
                break;
            }
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
