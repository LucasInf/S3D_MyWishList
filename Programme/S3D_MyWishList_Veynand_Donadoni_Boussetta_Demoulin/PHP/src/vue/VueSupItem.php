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
    <h2>Supprimer l'item : {$i['nom']} ? </h2>
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
</html>
FIN;
        return $html;
    }

}
