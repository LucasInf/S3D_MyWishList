<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueCreationListe
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

    private function lesItems() : string {
        $html = '';
        foreach($this->tab as $item){
            $html .= "<li>{$item['nom']},{$item['descr']}, {$item['tarif']}</li>";
        }
        $html = "<ul>$html</ul>";
        return $html;
    }

    private function unItem() : string {
        $i = $this->tab[0];
        $html = "<h2>Item {$i['id']}</h2>";
        $html .= "<b>Nom:</b> {$i['nom']}<br>";
        $html .= "<b>Descr:</b> {$i['descr']}<br>";
        $html .= "<b>Tarif:</b> {$i['tarif']}<br>";
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
  			case 0 : {
  				$content = 'accueil racine du site';
  				break;
  			}
        case 1 : { // liste des items
            $content = $this->lesItems();
            break;
        }
        case 2 : { // un item
            $content = $this->unItem();
            break;
        }
        case 3 : {
            $content = $this->formItem();
            break;
        }
        case 4 : {
            $content = $this->deleteItem();
            break;
        }
        case 5 : {
            $content = $this->modifyItem();
            break;
        }
        case 6 : {
            $content = $this->choixdeleteItem();
            break;
        }
        case 7 : {
            $content = $this->choixmodifyItem();
            break;
        }




  		}

  		$url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
      $url_items    = $this->container->router->pathFor( 'aff_items'             ) ;
  		$url_item_2     = $this->container->router->pathFor( 'aff_item' , ['id' => 2] ) ;
  		$url_form_item = $this->container->router->pathFor( 'formItem'              ) ;

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
  				<li><a href="$url_item_2">Item 2</a></li>
  				<li><a href="$url_form_item">Nouveau item</a></li>
          <li><a href="$url_choixdeleteItem">Supprimer un Item</a></li>
  				<li><a href="$url_choixmodifyItem">Modifier un Item</a></li>
  			</ul>
  		</nav>
      $content
    </body>
  </html>
  FIN;
  		return $html;
  	}
  }
