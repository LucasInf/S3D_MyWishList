<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueSupListe;
use \mywishlist\models\Liste;

class ControlSupListe
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function deleteListe(Request $rq, Response $rs, $args): Response
    {
        session_start();

        $token = $_SESSION['token'];
        $titre = $_SESSION['no'];
        if (!($token == '')) {
            $i = Liste::where('no', '=', $titre)->first();
            if ($i->token == $token) {
                $i->delete();
                $url_liste = $this->container->router->pathFor('aff_listes');
                return $rs->withRedirect($url_liste);
            } else {
              $vue = new VueErreur( [] , $this->container ) ;
              $rs->getBody()->write( $vue->render( 0 ) ) ;
              return $rs;
            }

        } else {
          $vue = new VueErreur( [] , $this->container ) ;
              $rs->getBody()->write( $vue->render( 0 ) ) ;
              return $rs;
        }
        return $rs;
    }

    public function choixdeleteListe(Request $rq, Response $rs, $args): Response{
        $vue = new VueSupListe([], $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }

}
