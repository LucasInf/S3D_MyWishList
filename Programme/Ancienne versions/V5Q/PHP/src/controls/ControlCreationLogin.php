<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueCreationLogin;
use \mywishlist\models\User;

class ControlCreationLogin
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    //permet de reunir les information pour creer un user
    public function formlogin(Request $rq, Response $rs, $args): Response
    {
        $vue = new VueCreationLogin([], $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }

    //permet de creer un user
    public function nouveaulogin(Request $rq, Response $rs, $args): Response
    {
        $post = $rq->getParsedBody();
        $login = filter_var($post['login'], FILTER_SANITIZE_STRING);
        $pass = filter_var($post['pass'], FILTER_SANITIZE_STRING);
        $_SESSION['login']=filter_var($post['login'], FILTER_SANITIZE_STRING);
        $_SESSION['pass']=filter_var($post['pass'], FILTER_SANITIZE_STRING);

        echo $_SESSION['login'];
        echo $_SESSION['pass'];
        $u2 = User::where('login', '=', $login)->first();
        if ($u2 == null) {
            $u = new User();
            $u->login = $login;
            $u->pass = password_hash($pass, PASSWORD_DEFAULT);
            $u->save();
        } else {
            $login = 'existe déjà';
        }

        $vue = new VueCreationLogin(['login' => $login], $this->container);
        $rs->getBody()->write($vue->render(2));
        return $rs;
    }


}