<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueModificationItem;
use \mywishlist\models\Item;

class ControlModificationItem
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function modifyItem(Request $rq, Response $rs, $args): Response{
        session_start();
        $post = $rq->getParsedBody() ;
        $liste_id    = $_SESSION['no'] ;
        $id     = $_SESSION['itemModif'] ;
        if(!($liste_id==null)){
            $i = Item::where( 'id', '=', $id) ->first() ;
            if($i->liste_id==$liste_id){
                $newN = filter_var($post['nouveaunom'],FILTER_SANITIZE_STRING);
                $newD = filter_var($post['nouveaudescr'],FILTER_SANITIZE_STRING);
                $newT = filter_var($post['nouveautarif'],FILTER_SANITIZE_STRING);
                $i->nom = $newN;
                $i->descr = $newD;
                $i->tarif = $newT;
                $i->update();
                $url_items = $this->container->router->pathFor( 'aff_liste', ['no' => $_SESSION['no']] ) ;
                return $rs->withRedirect($url_items);
            }else{
                echo "L'item n'a pas été trouvée car les informations données ne sont pas valides";
            }

        }else{
            echo "L'item n'a pas été trouvée car aucun identifiant de liste n'a été donné";
        }

    }

    public function choixmodifyItem(Request $rq, Response $rs, $args): Response{
        $item = Item::find( $args['id'] ) ;
        $vue = new VueModificationItem([$item->toArray()], $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }

}
