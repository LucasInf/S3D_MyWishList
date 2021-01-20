<?php

declare(strict_types=1);

namespace mywishlist\controls;


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VuePartageURL;
use mywishlist\models\Liste;

class ControlPartageURL
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function share(Request $rq, Response $rs, $args) : Response {
        session_start();
        $_SESSION['PartageURL']=$this->container->router->pathFor( 'aff_liste', ['token' => $_SESSION['token']] ) ;

        $url_items = $this->container->router->pathFor( 'aff_liste', ['token' => $_SESSION['token']] ) ;
        return $rs->withRedirect($url_items);
    }
}