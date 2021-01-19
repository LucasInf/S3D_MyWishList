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
        session_start();
            $url_new_item = $this->container->router->pathFor('newItem');
            $html = <<<FIN
    <form method="POST" action="$url_new_item">
    <h2>Ajout d'un item dans la liste {$_SESSION['no']}</h2>
    <label>Nom:<br> <input type="text" name="nom"/></label><br>
	<label>Description:<br> <input type="text" name="descr"/></label><br>
	<label>Tarif: <br><input type="number" name="tarif"/></label><br>
	<button type="submit">Enregistrer item</button>
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
        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;
        $url_deconnexion   = $this->container->router->pathFor( 'deconnexion'               ) ;
        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;
        $url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;

        if(isset($_SESSION['login'])) {
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
				<li><a href="$url_listes">Listes</a></li>
				<li><a href="$url_deconnexion">Deconnexion</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        }else {
            $html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
    <title>Exemple</title>
    <link rel="stylesheet" href="CSS/design.css" />
  </head>
  <body>
		<h1><a href="$url_accueil">Wish List</a></h1>
		<nav>
			<ul>
				<li><a href="$url_accueil">Accueil</a></li>
				<li><a href="$url_listes">Listes</a></li>
				<li><a href="$url_formlogin">S'inscrire</a></li>
				<li><a href="$url_testform">Se connecter</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        }
        return $html;
    }

}
