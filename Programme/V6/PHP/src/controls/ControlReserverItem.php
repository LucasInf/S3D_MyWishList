<?php

declare(strict_types=1);

namespace mywishlist\controls;


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueReserverItem;
use \mywishlist\models\Item;
use \mywishlist\models\Reservation;

class ControlReserverItem
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function reserverItem(Request $rq, Response $rs, $args): Response  {
        session_start();

        $post = $rq->getParsedBody() ;

        $liste_id    = $_SESSION['listeReserv'];
        $id     = $_SESSION['itemReserv'];
        $nomP     = filter_var($post['nomP']       , FILTER_SANITIZE_STRING);

        $token = random_bytes(100);
        $token = bin2hex($token);

        if(!($liste_id==null)){
            $i = Item::where( 'id', '=', $id) ->first() ;
            $Res = Reservation::where( 'idItem', '=', $id) ->first() ;
            if($i->liste_id==$liste_id){
                if($Res->idItem == null){
                    $newRes= new Reservation();
                    $newRes->idReservation = $token;
                    $newRes->idItem = $i->id;
                    $newRes->liste_id = $liste_id;
                    $newRes->nomParticipant= $nomP;
                    $newRes->save();
                    $url_items = $this->container->router->pathFor( 'aff_items' ) ;
                    return $rs->withRedirect($url_items);
                }else{
                    echo "L'item est déja réservé";
                }
            }else{
                echo "L'item n'a pas été trouvée car les informations données ne sont pas valides";
            }
        }else{
            echo "L'item n'a pas été trouvée car aucun identifiant de liste n'a été donné";
        }
        return $rs;
    }

    public function choixreserverItem(Request $rq, Response $rs, $args): Response{
        $item = Item::find( $args['id'] ) ;
        $vue = new VueReserverItem([$item->toArray()], $this->container);
        $rs->getBody()->write($vue->render(0));
        return $rs;
    }


}
