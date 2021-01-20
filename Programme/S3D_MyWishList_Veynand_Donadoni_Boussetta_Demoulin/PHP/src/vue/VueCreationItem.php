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
    <form method="POST" action="$url_new_item" enctype="multipart/form-data">
    <h2>Ajout d'un item dans la liste {$_SESSION['no']}</h2>
    <label>Nom:<br> <input type="text" name="nom"/></label><br>
	<label>Description:<br> <input type="text" name="descr"/></label><br>
	<label>Tarif: <br><input type="number" name="tarif"/></label><br>
	<input type="file" name="fileToUpload" id="fileToUpload">
	<input type="submit" value="Upload Image" name="submit">
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
        $url_voslistes     = $this->container->router->pathFor( 'aff_voslistes'             ) ;
        $url_form_liste = $this->container->router->pathFor( 'formListe'              ) ;
        $url_formlogin  = $this->container->router->pathFor( 'formlogin'              ) ;
        $url_testform   = $this->container->router->pathFor( 'testform'               ) ;
        $url_deconnexion   = $this->container->router->pathFor( 'deconnexion'               ) ;
        $url_listesCr = $this->container->router->pathFor( 'aff_createur'             ) ;


        if(isset($_SESSION['login'])) {
            $ada = "<li><a href=".$url_voslistes.">Vos Listes</a></li>
				<li><a href=".$url_form_liste.">Nouvelle Liste</a></li>
				<li><a href=".$url_deconnexion.">Deconnexion</a></li>";
        }else{
            $ada = "<li><a href=".$url_formlogin.">S'inscrire</a></li>
			<li><a href=".$url_testform.">Se connecter</a></li>";

        }
        $html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../../CSS/design.css" />
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
