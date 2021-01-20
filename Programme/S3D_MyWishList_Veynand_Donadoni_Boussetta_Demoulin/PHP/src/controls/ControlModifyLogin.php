<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueModifyLogin;
use \mywishlist\models\User;

class ControlModifyLogin
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    //permet de modifier un user
    public function modifylogin(Request $rq, Response $rs, $args): Response
    {
        session_start();
        $post = $rq->getParsedBody();
        $login = $_SESSION['login'];
        $pass = filter_var($post['pass'], FILTER_SANITIZE_STRING);
        $Npass = filter_var($post['Npass'], FILTER_SANITIZE_STRING);

        $u = User::where('id', '=', $login)->first();
        $verifpass = password_verify($pass, $u->pass);
        if ($u != null) {
            if($verifpass == 1){
                $u->login = $login;
                $u->pass = password_hash($Npass, PASSWORD_DEFAULT);
                $u->save();
            } else {
                $login = 'Ancien mot de passe incorrect';
            }
        }else{
            $login = 'Compte non existant';
        }

        $url_items = $this->container->router->pathFor( 'aff_liste', ['token' => $_SESSION['token']] ) ;
        return $rs->withRedirect($url_items);
    }

    public function choixmodifylogin(Request $rq, Response $rs, $args): Response{
        $vue = new VueModifyLogin([], $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }


}