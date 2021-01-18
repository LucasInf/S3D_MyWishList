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

        $i = $this->tab[0];
        session_start();
        $_SESSION['itemModif'] = $i['id'];

        $url_modifyItem = $this->container->router->pathFor( 'modifyItem' ) ;
        $html = <<<FIN
    <form method="POST" action="$url_modifyItem">
    <h2>Vous allez modifier l'item {$_SESSION['itemModif']} </h2>
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
        $url_deconnexion   = $this->container->router->pathFor( 'deconnexion'               ) ;

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
				<li><a href="$url_deconnexion">Deconnexion</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}
