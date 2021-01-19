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

        $i = $this->tab[0];
        $url_reserverItem = $this->container->router->pathFor('reserverItem');
        session_start();
        $_SESSION['itemReserv'] = $i['id'];
        $html = <<<FIN
    <form method="POST" action="$url_reserverItem">
    <h2>Reserver l'item {$i['nom']} ?</h2>
    <label>Nom participant:<br> <input type="text" name="nomP"/></label><br>
	<button type="submit">Reserver item</button>
</form>
FIN;
        return $html;
    }

    public function render( int $select ) : string {

        switch ($select) {
            case 0 : {
                $content = $this->choixreserverItem();
                break;
            }
        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;

        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;


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
				<li><a href="$url_testform">Listes</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}
