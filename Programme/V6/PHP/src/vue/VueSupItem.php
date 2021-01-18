<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueSupItem
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function choixdeleteItem() : string {

        $i = $this->tab[0];
        $url_deleteItem = $this->container->router->pathFor( 'deleteItem' ) ;

        session_start();
        $_SESSION['itemSup'] = $i['id'];

        $html = <<<FIN
<form method="POST" action="$url_deleteItem">
    <label>Etes vous sur de vouloir supprimer l'item {$_SESSION['itemSup']} ? </label><br>
    <button type="submit">Supprimer l'Item</button>
</form>
FIN;
        return $html;
    }

    public function render( int $select ) : string {

        switch ($select) {
            case 1 : {
                $content = $this->choixdeleteItem();
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
