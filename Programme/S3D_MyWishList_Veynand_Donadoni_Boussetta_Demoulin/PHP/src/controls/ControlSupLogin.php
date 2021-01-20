<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueSupLogin;
use \mywishlist\models\User;

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

        $u = User::where('login', '=', $login)->first();
        $ls = Liste::where('user_id', '=', $u->id)->first();

        if ($u != null) {
            if($pass == $u->pass){
                foreach($ls as $l){
                    $is = Item::where('liste_id', '=', $ls->no)->first();
                    foreach ($is as $i){
                        $i->delete();
                    }
                    $l->delete();
                }
                $u->delete();
            } else {
                $login = 'Ancien mot de passe incorrect';
            }
        }else{
            $login = 'Compte non existant';
        }
    }

    public function choixsuplogin(Request $rq, Response $rs, $args): Response{
        $vue = new VueSupLogin([], $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }


}