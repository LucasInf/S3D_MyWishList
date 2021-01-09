<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueCreationItem
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function formItem() : string {
            $url_new_item = $this->container->router->pathFor('newItem');
            $html = <<<FIN
    <form method="POST" action="$url_new_item">
    <label>Liste ID:<br> <input type="number" name="liste_id"/></label><br>
    <label>Nom:<br> <input type="text" name="nom"/></label><br>
	<label>Description:<br> <input type="text" name="descr"/></label><br>
	<label>Tarif: <br><input type="number" name="tarif"/></label><br>
	<button type="submit">Enregistrer item</button>
</form>
FIN;
        return $html;
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

    private function choixdeleteItem() : string {
        $url_deleteItem = $this->container->router->pathFor( 'deleteItem' ) ;
        $html = <<<FIN
<form method="POST" action="$url_deleteItem">
    <label>Nom:<br> <input type="text" name="nom"/></label><br>
    <label>Liste ID: <br><input type="number" name="liste_id"/></label><br>
    <button type="submit">Supprimer l'Item</button>
</form>
FIN;
        return $html;
    }


    public function render( int $select ) : string {

        switch ($select) {
            case 1 : {
                $content = $this->formItem();
                break;
            }
            case 2 : {
                $content = $this->choixmodifyItem();
                break;
            }
            case 3 : {
                $content = $this->choixdeleteItem();
                break;
            }
        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_items     = $this->container->router->pathFor( 'aff_items'             ) ;
        $url_form_item = $this->container->router->pathFor( 'formItem'              ) ;
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
				<li><a href="$url_listes">Listes</a></li>
				<li><a href="$url_form_liste">Nouvelle Liste</a></li>
				<li><a href="$url_formlogin">Nouveau login</a></li>
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
