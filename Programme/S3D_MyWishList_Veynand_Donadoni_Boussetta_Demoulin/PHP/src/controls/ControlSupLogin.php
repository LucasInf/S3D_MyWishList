<?php

declare(strict_types=1);

namespace mywishlist\controls;

use mywishlist\vue\VueErreur;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueSupLogin;
use \mywishlist\models\User;
use \mywishlist\models\Liste;
use \mywishlist\models\Item;

class ControlSupLogin
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    //permet de supprimer un user
    public function suplogin(Request $rq, Response $rs, $args): Response
    {
        session_start();
        $post = $rq->getParsedBody();
        $login = $_SESSION['login'];
        $pass = filter_var($post['pass'], FILTER_SANITIZE_STRING);

        $u = User::where('id', '=', $login)->first();
        $ls = Liste::where('user_id', '=', $u->id)->get();
        $verifpass = password_verify($pass, $u->pass);
        if ($u != null) {
            if ($verifpass) {
                foreach ($ls as $l) {
                    $is = Item::where('liste_id', '=', $l['no'])->get();
                    foreach ($is as $i) {
                        $i->delete();
                    }
                    $l->delete();
                }
                $u->delete();
                session_destroy();
                $vue = new VueSupLogin( [] , $this->container ) ;
                $rs->getBody()->write( $vue->render( 0 ) ) ;
                return $rs;
            } else {
                $vue = new VueErreur( [] , $this->container ) ;
                $rs->getBody()->write( $vue->render( 0 ) ) ;
                return $rs;
            }
        }else{
            $vue = new VueErreur( [] , $this->container ) ;
            $rs->getBody()->write( $vue->render( 0 ) ) ;
            return $rs;
        }

    }

    public function choixsuplogin(Request $rq, Response $rs, $args): Response{
        $vue = new VueSupLogin([], $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }


}