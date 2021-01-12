<?php
declare(strict_types=1);

namespace mywishlist\vue;

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
            $url_liste   = $this->container->router->pathFor( 'aff_liste', ['no' => $liste['no']] ) ;
			$html .= "<li><a href='$url_liste'>{$liste['titre']}</a>, {$liste['description']}</li>";
		}
		$html = "<ul>$html</ul>";
		return $html;
	}

    private function uneListe() : string {
        $l = $this->tab[0];
        $url_share = $this->container->router->pathFor( 'share', ['no' => $l['no']] ) ;
        $html = "<h2>Liste {$l['no']}</h2>";
        $html .= "<b>Titre:</b> {$l['titre']}<br>";
        $html .= "<b>Description:</b> {$l['description']}<br>";
        $html .= "<a href='$url_share'>Partager</a>";

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

	private function share():string{
        $l = $this->tab[0];
        $html=$this->container->router->pathFor( 'aff_liste', ['no' => $l['no']] ) ;

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
            case 2 : {
                $content = $this->uneListe();
                break;
            }
			case 5 : {
				$content = $this->formListe();
				break;
			}
			case 8 : {
				$content = $this->testform();
				break;
			}
			case 9 : {
				$res = ($this->tab['res'])? 'OK' : 'KO';
				$content = 'Mot de passe <b>'.$res.'</b>';
				break;
			}
			case 10 : {
				$url_deconnexion    = $this->container->router->pathFor( 'deconnexion' ) ;
				$content = "<a href='$url_deconnexion'>Deconnexion</a>";
				break;
			}
            case 11:{
                $content = $this->share();
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