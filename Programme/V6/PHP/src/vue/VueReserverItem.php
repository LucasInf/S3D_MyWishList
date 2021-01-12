<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueReserverItem
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function choixreserverItem() : string {
        $url_reserverItem = $this->container->router->pathFor('reserverItem');
        $html = <<<FIN
    <form method="POST" action="$url_reserverItem">
    <label>Nom participant:<br> <input type="text" name="nomP "/></label><br>
	<label>Liste ID:<br> <input type="text" name="liste_id"/></label><br>
	<label>Id item:<br> <input type="number" name="id "/></label><br>
	<button type="submit">Reserver item</button>
</form>
FIN;
        return $html;
    }

    public function render( int $select ) : string {

        switch ($select) {
            case 1 : {
                $content = $this->ReserverItem();
                break;
            }
        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_items     = $this->container->router->pathFor( 'aff_items'             ) ;
        $url_choixreserveritem = $this->container->router->pathFor( 'choixreserverItem'              ) ;
        $url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;
        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;
        $url_choixmodifyItem  = $this->container->router->pathFor( 'choixmodifyItem'              ) ;
        $url_choixdeleteItem   = $this->container->router->pathFor( 'choixdeleteItem'               ) ;

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
				<li><a href="$url_choixreserveritem">Reserver un item</a></li>
				<li><a href="$url_testform">S'inscrire</a></li>
        <li><a href="$url_choixmodifyItem">Modifier l'item</a></li>
				<li><a href="$url_choixdeleteItem">Supprimer l'item</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}
