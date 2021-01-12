<?php
declare(strict_types=1);

namespace mywishlist\vue;

use function React\Promise\all;

class VueWish {

    private $tab; // tab array PHP
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;
    }

    private function lesListes() : string {
        $html = '';
        foreach($this->tab as $liste){
            $html .= "<li>{$liste['no']},{$liste['user_id']}{$liste['titre']}, {$liste['description']}, {$liste['token']}</li>";
        }
        $html = "<ul>$html</ul>";
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

    private function uneListe() : string {
        $l = $this->tab[0];
        $html = "<h2>Liste {$l['no']}</h2>";
        $html .= "<b>Titre:</b> {$l['titre']}<br>";
        $html .= "<b>Description:</b> {$l['description']}<br>";
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

    private function formListe() : string {
        $url_new_liste = $this->container->router->pathFor( 'newListe' ) ;
        $html = <<<FIN
<form method="POST" action="$url_new_liste">
	<label>Titre:<br> <input type="text" name="titre"/></label><br>
	<label>Description: <br><input type="text" name="description"/></label><br>
	<button type="submit">Enregistrer la liste</button>
</form>	
FIN;
        return $html;
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

    private function formlogin() : string {
        $url_nouveaulogin = $this->container->router->pathFor( 'nouveaulogin' ) ;
        $html = <<<FIN
<form method="POST" action="$url_nouveaulogin">
	<label>Login:<br> <input type="text" name="login"/></label><br>
	<label>Mot de passe: <br><input type="text" name="pass"/></label><br>
	<button type="submit">Enregistrer le login</button>
</form>	
FIN;
        return $html;
    }

    private function testform() : string {
        $url_testpass = $this->container->router->pathFor( 'testpass' ) ;
        $html = <<<FIN
<form method="POST" action="$url_testpass">
	<label>Login:<br> <input type="text" name="login"/></label><br>
	<label>Mot de passe: <br><input type="text" name="pass"/></label><br>
	<button type="submit">Tester le login</button>
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
            case 0 : {
                $content = 'accueil racine du site';
                break;
            }
            case 1 : { // liste des listes
                $content = $this->lesListes();
                break;
            }
            case 2 : { // liste des items
                $content = $this->lesItems();
                break;
            }
            case 3 : { // liste 1
                $content = $this->uneListe();
                break;
            }
            case 4 : { // un item
                $content = $this->unItem();
                break;
            }
            case 5 : {
                $content = $this->formListe();
                break;
            }
            case 6 : {
                $content = $this->formItem();
                break;
            }
            case 7 : {
                $content = $this->formlogin();
                break;
            }
            case 8 : {
                $content = 'Login <b>'.$this->tab['login'].'</b> enregistré';
                break;
            }
            case 9 : {
                $content = $this->testform();
                break;
            }
            case 10 : {
                $res = ($this->tab['res'])? 'OK' : 'KO';
                $content = 'Mot de passe <b>'.$res.'</b>';
                break;
            }
            case 11 : {
                $url_deconnexion    = $this->container->router->pathFor( 'deconnexion' ) ;
                $content = "<a href='$url_deconnexion'>Deconnexion</a>";
                break;
            }
            case 12 : {
                $content = $this->deleteItem();
                break;
            }
            case 13 : {
                $content = $this->modifyItem();
                break;
            }
            case 14 : {
                $content = $this->choixdeleteItem();
                break;
            }
            case 15 : {
                $content = $this->choixmodifyItem();
                break;
            }

        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;
        $url_items    = $this->container->router->pathFor( 'aff_items'             ) ;
        $url_liste_1    = $this->container->router->pathFor( 'aff_liste', ['no' => 1] ) ;
        $url_item_2     = $this->container->router->pathFor( 'aff_item' , ['id' => 2] ) ;
        $url_form_liste = $this->container->router->pathFor( 'formListe'              ) ;
        $url_form_item = $this->container->router->pathFor( 'formItem'              ) ;
        $url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;
        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;
        $url_choixdeleteItem  = $this->container->router->pathFor( 'choixdeleteItem'              ) ;
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
				<li><a href="$url_listes">Listes</a></li>
				<li><a href="$url_items">Items</a></li>
				<li><a href="$url_liste_1">Liste 1</a></li>
				<li><a href="$url_item_2">Item 2</a></li>
				<li><a href="$url_form_liste">Nouvelle Liste</a></li>
				<li><a href="$url_form_item">Nouveau item</a></li>
				<li><a href="$url_formlogin">Nouveau login</a></li>
				<li><a href="$url_testform">Test login</a></li>
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