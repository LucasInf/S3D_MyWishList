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
        $url_ListePublic = $this->container->router->pathFor( 'verifPublic', ['token' => $l['token']]             ) ;

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
            if ($liste["public"]){
                $html .= "<a href='$url_ListePublic'>Passer la liste en privé</a><br><br>";
            }else{
                $html .= "<a href='$url_ListePublic'>Passer la liste en public</a><br><br>";
            }

        }


        if (isset($_SESSION['PartageURL'])){
            $html .= "{$_SESSION['PartageURL']}<br>";
            unset($_SESSION['PartageURL']);
        }else{
            $html .= "<a href='$url_share'>Partager</a><br>";
        }
        $html .= "<h3>Items</h3>";

        foreach($items as $item){
            $ir=null;
            $r= false;
            $url_item   = $this->container->router->pathFor( 'aff_item', ['id' => $item['id']] ) ;
            $url_reserv   = $this->container->router->pathFor( 'choixreserverItem',['id' => $item['id']]) ;

            $html .= "<li><a href='$url_item'>{$item['nom']}</a> {$item['tarif']}€<br>";
            foreach($reservs as $reserv){
                if ($reserv['idItem'] == $item['id']){
                   $r = true;
                   $ir=$item['id'];
                }
            }
            if ($r){
                if(isset($_SESSION['login']) && $liste['user_id']==$_SESSION['login'] && $liste['expiration'] >= date('Y-m-d')) {
                    $html .="<strong>DEJA RESERVE</strong></li><br>";
                }else{
                    $nomR= Reservation::where('idItem', '=', $ir)->first();
                    $html .="<strong>DEJA RESERVE PAR : {$nomR['nomParticipant']}</strong></li><br>";
                }
            }else{
                if(isset($_SESSION['login']) && $liste['user_id']==$_SESSION['login']){
                    $html .="<strong>Vous ne pouvez pas reserver vous etes le createur de la liste</strong></li><br>";
                }else{
                    $html .="<a href='$url_reserv'><strong>RESERVER {$item['nom']}</strong></a></li><br>";
                }

            }

        }

        if(isset($_SESSION['login']) && $liste['user_id']==$_SESSION['login']) {
            $html .= "<a href='$url_form_item'>Ajouter un item</a><br>";
        }


        $html .= "<h3>Messages</h3>";
        if(isset($_SESSION['login']) && $liste['user_id']==$_SESSION['login'] && $liste['expiration'] >= date('Y-m-d')) {
            $html .="<ul>Vous n'y avez pas encore acces</ul>";
        }else{
            if ($msgs->first() == null){
                $html .="<ul>Il 'y a aucun messages pour cette liste</ul>";
            }else {
                foreach($msgs as $msg){
                    $html .= "<ul><b>{$msg['auteur']} : </b>{$msg['msg']}</ul><br>";
                }
            }
            $html .= "<a href='$url_msg'><br>Ajouter un message à la liste</a><br>";
        }




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
