<?php
declare(strict_types=1);

namespace mywishlist\vue;

use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\models\Message;
use mywishlist\models\Reservation;

class VueAffichageListe
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function uneListe() : string {
        session_start();

        $l = $this->tab[0];
        $url_share = $this->container->router->pathFor( 'share', ['token' => $l['token']] ) ;
        $url_msg = $this->container->router->pathFor( 'ajoutMessageliste', ['token' => $l['token']] ) ;

        $url_choixmodifyListe = $this->container->router->pathFor( 'choixmodifyListe', ['token' => $l['token']] ) ;
        $url_choixdeleteListe = $this->container->router->pathFor( 'choixdeleteListe',['token' => $l['token']] ) ;
        $url_form_item = $this->container->router->pathFor( 'formItem'              ) ;

        $_SESSION['listeReserv'] = $l['no'];

        $_SESSION['token'] = $l['token'];

        $_SESSION['no'] = $l['no'];

        $_SESSION['titre'] = $l['titre'];

        $items = Item::where('liste_id', '=', $l['no'])->get();
        $msgs = Message::where('liste_id', '=', $l['no'])->get();
        $reservs = Reservation::where('liste_id', '=', $l['no'])->get();
        $liste= Liste::where('no','=',$l['no'])->first();

        $html = "<h2>LISTE : {$l['titre']}</h2>";
        $html .= "<b>Description:</b> {$l['description']}<br>";
        $html .= "<b>Date d'expiration:</b> {$l['expiration']}<br>";


        if(isset($_SESSION['login']) && $liste['user_id']==$_SESSION['login']) {

            $html .= "<a href='$url_choixmodifyListe'>Modifier la liste</a><br>";
            $html .= "<a href='$url_choixdeleteListe'>Supprimer la liste</a><br><br>";
        }


        if (isset($_SESSION['PartageURL'])){
            $html .= "{$_SESSION['PartageURL']}<br>";
            unset($_SESSION['PartageURL']);
        }else{
            $html .= "<a href='$url_share'>Partager</a><br>";
        }
        $html .= "<h3>Items</h3>";

        foreach($items as $item){
            $r= false;
            $url_item   = $this->container->router->pathFor( 'aff_item', ['id' => $item['id']] ) ;
            $url_reserv   = $this->container->router->pathFor( 'choixreserverItem',['id' => $item['id']]) ;

            $html .= "<li><a href='$url_item'>{$item['nom']}</a> {$item['tarif']}€<br>";
            foreach($reservs as $reserv){
                if ($reserv['idItem'] == $item['id']){
                   $r = true;
                }
            }
            if ($r){
                $html .="<strong>DEJA RESERVE PAR : {$reserv['nomParticipant']}</strong></li><br>";
            }else{
                $html .="<a href='$url_reserv'><strong>RESERVER {$item['nom']}</strong></a></li><br>";
            }

        }

        if(isset($_SESSION['login']) && $liste['user_id']==$_SESSION['login']) {
            $html .= "<a href='$url_form_item'>Ajouter un item</a><br>";
        }


        $html .= "<h3>Messages</h3>";

        if ($msgs->first() == null){
            $html .="<ul>Il 'y a aucun messages pour cette liste</ul>";
        }else {
            foreach($msgs as $msg){
                $html .= "<ul><b>{$msg['auteur']} : </b>{$msg['msg']}</ul><br>";
            }
        }
        $html .= "<a href='$url_msg'><br>Ajouter un message à la liste</a><br>";



        $html = "<ul>$html</ul>";
        return $html;
    }


    public function render( int $select ) : string {

        switch ($select) {
            case 2 : {
                $content = $this->uneListe();
                break;
            }

        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;

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
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}
