<?php

declare(strict_types=1);

namespace mywishlist\controls;


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueLogin;
use \mywishlist\models\User;

class ControlLogin
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    //permet de recuperer l'user a tester
    public function testform(Request $rq, Response $rs, $args) : Response {
        $vue = new VueLogin( [] , $this->container ) ;
        if (isset($_SESSION['iduser'])) {
            $rs->getBody()->write( $vue->render( 4 ) ) ;
        } else {
            $rs->getBody()->write( $vue->render( 3 ) ) ;
        }
        return $rs;
    }

    //permet de tester un user
    public function testpass(Request $rq, Response $rs, $args) : Response {
        $post = $rq->getParsedBody() ;
        $login       = filter_var($post['login']       , FILTER_SANITIZE_STRING) ;
        $pass = filter_var($post['pass'] , FILTER_SANITIZE_STRING) ;
        $u = User::where('login','=',$login)->first();
        $res = password_verify($pass,$u->pass);
        if ($res) $_SESSION['iduser'] = $u->id;

        $vue = new VueLogin( [ 'res' => $res ] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 5 ) ) ;
        return $rs;
    }

    //permet de se deconnecter
    public function deconnexion(Request $rq, Response $rs, $args) : Response {
        session_destroy();
        $_SESSION = [];
        $vue = new VueLogin( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 4 ) ) ;
        return $rs;
    }

}