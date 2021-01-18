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
        $liste = Liste::where('token','=',$args['token'])->first() ;
        $vue = new VuePartageURL( [ $liste->toArray() ] , $this->container ) ;
        $rs->getBody()->write( $vue->render(  1) ) ;
        return $rs;
    }
}