<?php
declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \mywishlist\vue\VueWish;
use \mywishlist\models\Liste;
use \mywishlist\models\Item;
use \mywishlist\models\User;

class MonControleur {
    private $container;

    public function __construct($container) {
        $this->container = $container;
    }
    public function accueil(Request $rq, Response $rs, $args) : Response {
        $vue = new VueWish( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 0 ) ) ;
        return $rs;
    }
    public function afficherListes(Request $rq, Response $rs, $args) : Response {
        // pour afficher la liste des listes de souhaits
        $listl = Liste::all() ;
        $vue = new VueWish( $listl->toArray() , $this->container ) ;
        $rs->getBody()->write( $vue->render( 1 ) ) ;
        return $rs;
    }
    public function afficherListe(Request $rq, Response $rs, $args) : Response {
        $liste = Liste::find( $args['no'] ) ;
        $vue = new VueWish( [ $liste->toArray() ] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 3 ) ) ;
        return $rs;
    }
    public function afficherItems(Request $rq, Response $rs, $args) : Response {
        $items = Item::all() ;
        $vue = new VueWish( $items->toArray() , $this->container ) ;
        $rs->getBody()->write( $vue->render( 2 ) ) ;
        return $rs;
    }
    public function afficherItem(Request $rq, Response $rs, $args) : Response {
        $item = Item::find( $args['id'] ) ;
        $vue = new VueWish( [ $item->toArray() ] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 4 ) ) ;
        return $rs;
    }
    public function formListe(Request $rq, Response $rs, $args) : Response {
        // pour afficher le formulaire liste
        $vue = new VueWish( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 5 ) ) ;
        return $rs;
    }


    public function formItem(Request $rq, Response $rs, $args) : Response {
        // pour afficher le formulaire item
        $vue = new VueWish( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 6 ) ) ;
        return $rs;
    }
    public function formlogin(Request $rq, Response $rs, $args) : Response {
        $vue = new VueWish( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 7 ) ) ;
        return $rs;
    }

    public function nouveaulogin(Request $rq, Response $rs, $args) : Response {
        $post = $rq->getParsedBody() ;
        $login       = filter_var($post['login']       , FILTER_SANITIZE_STRING) ;
        $pass = filter_var($post['pass'] , FILTER_SANITIZE_STRING) ;

        $u2 = User::where('login','=',$login)->first();
        if ($u2->id == 0) {
            $u = new User();
            $u->login = $login;
            $u->pass = password_hash($pass, PASSWORD_DEFAULT);
            $u->save();
        } else {
            $login = 'existe déjà';
        }

        $vue = new VueWish( [ 'login' => $login ] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 8 ) ) ;
        return $rs;
    }


    public function testform(Request $rq, Response $rs, $args) : Response {
        $vue = new VueWish( [] , $this->container ) ;
        if (isset($_SESSION['iduser'])) {
            $rs->getBody()->write( $vue->render( 9 ) ) ;
        } else {
            $rs->getBody()->write( $vue->render( 8 ) ) ;
        }
        return $rs;
    }

    public function deconnexion(Request $rq, Response $rs, $args) : Response {
        session_destroy();
        $_SESSION = [];
        $vue = new VueWish( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 10) ) ;
        return $rs;
    }

    public function testpass(Request $rq, Response $rs, $args) : Response {
        $post = $rq->getParsedBody() ;
        $login       = filter_var($post['login']       , FILTER_SANITIZE_STRING) ;
        $pass = filter_var($post['pass'] , FILTER_SANITIZE_STRING) ;
        $u = User::where('login','=',$login)->first();
        $res = password_verify($pass, $u->pass);

        if ($res) $_SESSION['iduser'] = $u->id;

        $vue = new VueWish( [ 'res' => $res ] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 9 ) ) ;
        return $rs;
    }











    public function newListe(Request $rq, Response $rs, $args) : Response {
        // pour enregistrer 1 liste.....
        $post = $rq->getParsedBody() ;
        $titre       = filter_var($post['titre']       , FILTER_SANITIZE_STRING) ;
        $description = filter_var($post['description'] , FILTER_SANITIZE_STRING) ;
        $l = new Liste();
        $l->titre = $titre;
        $l->description = $description;
        $l->save();

        $url_listes = $this->container->router->pathFor( 'aff_listes' ) ;
        return $rs->withRedirect($url_listes);

        //$listl = Liste::all() ;
        //$vue = new VueWish( $listl->toArray() , $this->container ) ;
        //$rs->getBody()->write( $vue->render( 1 ) ) ;
        //return $rs;
    }

    public function newItem(Request $rq, Response $rs, $args) : Response {
        // pour enregistrer 1 item.....
        $post = $rq->getParsedBody() ;
        $liste_id    = filter_var($post['liste_id']       , FILTER_SANITIZE_NUMBER_INT) ;
        $nom     = filter_var($post['nom']       , FILTER_SANITIZE_STRING) ;
        $descr = filter_var($post['descr'] , FILTER_SANITIZE_STRING) ;
        $tarif = filter_var($post['tarif'] , FILTER_SANITIZE_NUMBER_INT) ;
        $l = new Item();
        $l->liste_id = $liste_id;
        $l->nom = $nom;
        $l->descr = $descr;
        $l->tarif = $tarif;
        $l->save();

        $url_items = $this->container->router->pathFor( 'aff_items' ) ;
        return $rs->withRedirect($url_items);

    }

    public function deleteItem(Request $rq, Response $rs, $args) : Response {
        // pour choisir 1 item.....
        $post = $rq->getParsedBody() ;
        $liste_id    = filter_var($post['liste_id']       , FILTER_SANITIZE_NUMBER_INT) ;
        $nom     = filter_var($post['nom']       , FILTER_SANITIZE_STRING) ;
        $descr = filter_var($post['descr'] , FILTER_SANITIZE_STRING) ;
        $tarif = filter_var($post['tarif'] , FILTER_SANITIZE_NUMBER_INT) ;
        $i = Item::where( 'nom', 'LIKE', $nom )->first() ;
        $i->delete();
        $url_items = $this->container->router->pathFor( 'aff_items' ) ;
        return $rs->withRedirect($url_items);
    }

    public function choixdeleteItem(Request $rq, Response $rs, $args): Response{
        $vue = new VueWish([], $this->container);
        $rs->getBody()->write($vue->render(14));
        return $rs;
    }


    public function modifyItem(Request $rq, Response $rs, $args): Response{
        $post = $rq->getParsedBody() ;
        $liste_id    = filter_var($post['liste_id']       , FILTER_SANITIZE_NUMBER_INT) ;
        $nom     = filter_var($post['nom']       , FILTER_SANITIZE_STRING) ;
        $descr = filter_var($post['descr'] , FILTER_SANITIZE_STRING) ;
        $tarif = filter_var($post['tarif'] , FILTER_SANITIZE_NUMBER_INT) ;
        $i = Item::where( 'nom', 'LIKE', $nom )->first() ;
        $newN = filter_var($_POST['nouveaunom'],FILTER_SANITIZE_STRING);
        $newD = filter_var($_POST['nouveaudescr'],FILTER_SANITIZE_STRING);
        $newT = filter_var($_POST['nouveautarif'],FILTER_SANITIZE_STRING);
        $i->nom = $newN;
        $i->descr = $newD;
        $i->tarif = $newT;
        $i->update();
        $url_items = $this->container->router->pathFor( 'aff_items' ) ;
        return $rs->withRedirect($url_items);

    }

    public function choixmodifyItem(Request $rq, Response $rs, $args): Response{
        $vue = new VueWish([], $this->container);
        $rs->getBody()->write($vue->render(15));
        return $rs;
    }


}