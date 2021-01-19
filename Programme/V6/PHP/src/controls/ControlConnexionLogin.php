<?php

declare(strict_types=1);

namespace mywishlist\controls;


use mywishlist\vue\VueConnexionLogin;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueLogin;
use \mywishlist\models\User;

class ControlConnexionLogin
{
    private $container;
    static $session;

    public function __construct($container)
    {
        $this->container = $container;
    }

    //permet de recuperer l'user a tester
    public function testform(Request $rq, Response $rs, $args) : Response {
        session_start();

        $vue = new VueConnexionLogin( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 1 ) ) ;
        return $rs;
    }

    //permet de tester un user
    public function testpass(Request $rq, Response $rs, $args) : Response {
        session_start();

        $post = $rq->getParsedBody() ;
        $login       = filter_var($post['login']       , FILTER_SANITIZE_STRING) ;
        $pass = filter_var($post['pass'] , FILTER_SANITIZE_STRING) ;
        $u = User::where('login','=',$login)->first();
        if ($u == null){
            $res = false;
        }else {
            $res = password_verify($pass, $u->pass);
        }
        if ($res) $_SESSION['login'] = $u->id;
        $vue = new VueConnexionLogin( [ 'res' => $res ] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 2 ) ) ;
        return $rs;
    }


}