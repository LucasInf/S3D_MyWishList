<?php
declare(strict_types=1);

namespace mywishlist\vue;

class VueAjoutImage {

    private $tab; // tab array PHP
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function choixajoutImageItem() : string {
        $url_ajout_image = $this->container->router->pathFor('ajoutImage');
        $html = <<<FIN
    <form method="POST" action="$url_ajout_image">
    <label>Liste ID:<br> <input type="number" name="liste_id"/></label><br>
    <label>Nom Item:<br><input type="text" name="nom"/></label><br>
	<label>Image:<br> <input type="text" name="img"/></label><br>
	<button type="submit">Ajouter image item</button>
</form>
FIN;
        return $html;
    }

    public function render( int $select ) : string {

        switch ($select) {
            case 1 : {
                $content = $this->choixajoutImageItem() ;
                break;
            }
        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_choixajout_image    = $this->container->router->pathFor( 'choixajoutImage'                 ) ;

        $html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
    <title>Accueil</title>
    <link rel="stylesheet" href="CSS/design.css" />
  </head>
  <body>
		<h1><a href="$url_accueil">Wish List</a></h1>
		<nav>
		    <strong>
			    <ul>
			    	<li><a href="$url_choixajout_image">Ajouter image</a></li>
			    </ul>
			</strong>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }
}

