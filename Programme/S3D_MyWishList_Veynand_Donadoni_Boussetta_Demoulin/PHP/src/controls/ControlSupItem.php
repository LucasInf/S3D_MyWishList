<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueSupItem;
use \mywishlist\models\Item;

class ControlSupItem
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function deleteItem(Request $rq, Response $rs, $args) : Response {
        // pour choisir 1 item.....
        session_start();
        $liste_id    = $_SESSION['no'] ;
        $id     = $_SESSION['itemSup'] ;
        if(!($liste_id==null)){
            $i = Item::where( 'id', '=', $id) ->first() ;
            if($i->liste_id==$liste_id){        $i->delete();
                $url_liste = $this->container->router->pathFor( 'aff_liste', ['token' => $_SESSION['token']] ) ;
                return $rs->withRedirect($url_liste);
            }else{
              $vue = new VueErreur( [] , $this->container ) ;
              $rs->getBody()->write( $vue->render( 0 ) ) ;
              return $rs;
            }

        }else{
          $vue = new VueErreur( [] , $this->container ) ;
              $rs->getBody()->write( $vue->render( 0 ) ) ;
              return $rs;
        }
    }

    public function choixdeleteItem(Request $rq, Response $rs, $args): Response{
        $item = Item::find( $args['id'] ) ;
        $vue = new VueSupItem([$item->toArray()], $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }

}
