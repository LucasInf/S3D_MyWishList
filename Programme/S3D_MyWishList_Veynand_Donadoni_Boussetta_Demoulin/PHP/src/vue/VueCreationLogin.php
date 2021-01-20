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
                $content = '<h2>Login <b>'.$this->tab['login'].'</b> enregistré</h2>';
                break;
            }

        }
        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;
        $url_voslistes     = $this->container->router->pathFor( 'aff_voslistes'             ) ;
        $url_form_liste = $this->container->router->pathFor( 'formListe'              ) ;
        $url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;
        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;
        $url_listesCr = $this->container->router->pathFor( 'aff_createur'             ) ;
        $url_compte     = $this->container->router->pathFor( 'aff_compte'             ) ;


        if(isset($_SESSION['login'])) {
            $ada = "<li><a href=".$url_voslistes.">Vos Listes</a></li>
				<li><a href=".$url_form_liste.">Nouvelle Liste</a></li>
                <li><a href=".$url_compte.">Mon compte</a></li>";
        }else{
            $ada = "<li><a href=".$url_formlogin.">S'inscrire</a></li>
			<li><a href=".$url_testform.">Se connecter</a></li>";


        }
        $html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../CSS/design.css" />
    <title>Exemple</title>
  </head>
  <body>
		<h1><a href="$url_accueil">Wish List</a></h1>
		<nav>
			<ul>
				<li><a href="$url_accueil">Accueil</a></li>
				<li><a href="$url_listes">Listes</a></li>
				<li><a href="$url_listesCr">Liste créateur</a></li>
				$ada

			</ul>
		</nav>
    $content
  </body>
</html>
FIN;

        return $html;
    }
}
