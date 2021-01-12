<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueModificationItem
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function choixmodifyItem() : string {
        $url_modifyItem = $this->container->router->pathFor( 'modifyItem' ) ;
        $html = <<<FIN
    <form method="POST" action="$url_modifyItem">
    <label>Nom:<br> <input type="text" name="nom"/></label><br>
    <label>Liste ID:<br> <input type="number" name="liste_id"/></label><br>
    <label>Nouveau Nom:<br> <input type="text" name="nouveaunom"/></label><br>
    <label>Nouvelle description:<br> <input type="text" name="nouveaudescr"/></label><br>
    <label>Nouveau tarif:<br> <input type="number" name="nouveautarif"/></label><br>
    <button type="submit">Modifier l'Item</button>
    </form>
FIN;
        return $html;
    }

    public function render( int $select ) : string {

        switch ($select) {
            case 1 : {
                $content = $this->choixmodifyItem();
                break;
            }
        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_items    = $this->container->router->pathFor( 'aff_items'             ) ;
        $url_form_item = $this->container->router->pathFor( 'formItem'              ) ;
        $url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;
        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;
        $url_deconnexion   = $this->container->router->pathFor( 'deconnexion'               ) ;
        $url_choixdeleteItem   = $this->container->router->pathFor( 'choixdeleteItem'               ) ;
        $url_choixmodifyItem   = $this->container->router->pathFor( 'choixmodifyItem'               ) ;

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
				<li><a href="$url_items">Items</a></li>
				<li><a href="$url_form_item">Nouveau item</a></li>
				<li><a href="$url_deconnexion">Deconnexion</a></li>
				<li><a href="$url_choixmodifyItem">Modifier un item</a></li>
				<li><a href="$url_formlogin">Nouveau login</a></li>
				<li><a href="$url_testform">S'inscrire</a></li>
				<li><a href="$url_deconnexion">Deconnexion</a></li>
				<li><a href="$url_choixdeleteItem">Supprimer un item</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}
