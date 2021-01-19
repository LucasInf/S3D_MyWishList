<?php
declare(strict_types=1);

namespace mywishlist\vue;
use mywishlist\models\Liste;
use mywishlist\models\Reservation;

class VueAffichageItem
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }



    private function unItem() : string {
        session_start();
        $i = $this->tab[0];

        $url_choixdeleteItem   = $this->container->router->pathFor( 'choixdeleteItem',    ['id' => $i['id']]         ) ;
        $url_choixmodifyItem   = $this->container->router->pathFor( 'choixmodifyItem',    ['id' => $i['id']]         ) ;

        $html = "<h2>ITEM : {$i['nom']}</h2>";
        $html .= "<p><img src='../../img/{$i['img']}'/></p>";
        $html .= "<b>Description:</b> {$i['descr']}<br>";
        $html .= "<b>Tarif:</b> {$i['tarif']}<br>";

        $liste= Liste::where('no','=',$i['liste_id'])->first();
        $reserv = Reservation::where('idItem', '=', $i['id'])->first();
        if(isset($_SESSION['login']) && $liste['user_id']==$_SESSION['login'] && $reserv==null) {
            $html .= "<a href='$url_choixmodifyItem'>Modifier</a><br>";
            $html .= "<a href='$url_choixdeleteItem'>Supprimer</a><br>";
        }


        return $html;
    }


    public function render( int $select ) : string {

        switch ($select) {
            case 2 : { // un item
                $content = $this->unItem();
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
