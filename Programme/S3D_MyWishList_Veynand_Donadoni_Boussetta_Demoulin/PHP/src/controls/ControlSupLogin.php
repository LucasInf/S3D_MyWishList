<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueSupLogin;
use mywishlist\vue\VueDeconnexionLogin;
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
        $ls = Liste::where('user_id', '=', $u->id)->first();
        $verifpass = password_verify($pass, $u->pass);
        if ($u != null) {
            if($pass != null) {
                if ($verifpass == 1 ) {
                    foreach ($ls as $l) {
                        $is = Item::where('liste_id', '=', $ls->no)->first();
                        foreach ($is as $i) {
                            $i->delete();
                        }
                        $l->delete();
                    }
                    $u->delete();
                    $vue = new VueSupLogin( [] , $this->container ) ;
                    $rs->getBody()->write( $vue->render( 0 ) ) ;
                    return $rs;
                } else {
                    $rs= 'Ancien mot de passe incorrect';
                    return $rs;
                }
            }else{
                $rs = 'Veuillez inserer le mot de passe';
                return $rs;
            }
        }else{
            $rs = 'Compte non existant';
            return $rs;
        }
    }

    public function choixsuplogin(Request $rq, Response $rs, $args): Response{
        $vue = new VueSupLogin([], $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }


}