<?php

declare(strict_types=1);

namespace mywishlist\controls;

use mywishlist\vue\VueLogin;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \mywishlist\vue\VueWish;
use \mywishlist\models\User;

class ControlLogin
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function formlogin(Request $rq, Response $rs, $args): Response
    {
        $vue = new VueLogin([], $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }

    public function nouveaulogin(Request $rq, Response $rs, $args): Response
    {
        $post = $rq->getParsedBody();
        $login = filter_var($post['login'], FILTER_SANITIZE_STRING);
        $pass = filter_var($post['pass'], FILTER_SANITIZE_STRING);

        $u2 = User::where('login', '=', $login)->first();
        if ($u2 == null) {
            $u = new User();
            $u->login = $login;
            $u->pass = password_hash($pass, PASSWORD_DEFAULT);
            $u->save();
        } else {
            $login = 'existe déjà';
        }

        $vue = new VueLogin(['login' => $login], $this->container);
        $rs->getBody()->write($vue->render(2));
        return $rs;
    }

}