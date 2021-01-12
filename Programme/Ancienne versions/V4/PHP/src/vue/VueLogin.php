<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueLogin
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }



    //permet de recuperer l'user a tester
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

    public function render( int $select ) : string {

        switch ($select) {
            case 3 : {
                $content = $this->testform();
                break;
            }
            case 4 : {
                $url_deconnexion    = $this->container->router->pathFor( 'deconnexion' ) ;
                $content = "<a href='$url_deconnexion'>Deconnexion</a>";
                break;
            }
            case 5 : {
                $res = ($this->tab['res'])? 'OK' : 'KO';
                $content = 'Mot de passe <b>'.$res.'</b>';
                break;
            }

        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;
        $url_form_liste = $this->container->router->pathFor( 'formListe'              ) ;
        $url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;
        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;

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
				<li><a href="$url_testform">Test login</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}