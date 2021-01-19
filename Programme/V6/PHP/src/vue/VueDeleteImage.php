<?php
declare(strict_types=1);

namespace mywishlist\vue;

class VueDeleteImage {

    private $tab; // tab array PHP
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function choixdeleteImageItem() : string {
        $url_delete_image = $this->container->router->pathFor('deleteImage');
        $html = <<<FIN
    <form method="POST" action="$url_delete_image">
    <label>Liste ID:<br> <input type="number" name="liste_id"/></label><br>
    <label>Nom Item:<br><input type="text" name="nom"/></label><br>
	<button type="submit">Ajouter image item</button>
</form>
FIN;
        return $html;
    }

    public function render( int $select ) : string {

        switch ($select) {
            case 1 : {
                $content = $this->choixdeleteImageItem() ;
                break;
            }
        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_choixdelete_image    = $this->container->router->pathFor( 'choixdeleteImage'                 ) ;

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
			    	<li><a href="$url_choixdelete_image">Supprimer image</a></li>
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

