<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueCreationLogin
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    //permet de reunir les information pour creer un user
    private function formlogin() : string {
        $url_nouveaulogin = $this->container->router->pathFor( 'nouveaulogin' ) ;
        $html = <<<FIN
<form method="POST" action="$url_nouveaulogin">
	<label>Login:<br> <input type="text" name="login"/></label><br>
	<label>Mot de passe: <br><input type="text" name="pass"/></label><br>
	<button type="submit">S'inscrire</button>
</form>
FIN;
        return $html;
    }

    public function render( int $select ) : string {

        switch ($select) {
            case 1 : {
                $content = $this->formlogin();
                break;
            }
            case 2 : {
                $content = 'Login <b>'.$this->tab['login'].'</b> enregistré';
                break;
            }

        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;
        $url_form_liste = $this->container->router->pathFor( 'formListe'              ) ;
        $url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;
        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;


        if(isset($_SESSION['login'])) {
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
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        }else{
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
