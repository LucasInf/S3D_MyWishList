<?php

declare(strict_types=1);

namespace mywishlist\controls;


use mywishlist\models\Message;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueReserverItem;
use \mywishlist\models\Item;
use \mywishlist\models\Reservation;
use mywishlist\models\User;

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
        $msg    = filter_var($post['msg']       , FILTER_SANITIZE_STRING);

        if(!($liste_id==null)){
            $i = Item::where( 'id', '=', $id) ->first() ;

            $Res = Reservation::where( 'idItem', '=', $id) ->first() ;
            if($i->liste_id==$liste_id){

                if($Res->idItem == null){

                    $newRes= new Reservation();
                    $newRes->idItem = $i->id;
                    $newRes->liste_id = $liste_id;
                    if(isset($_SESSION['login'])) {
                        $nom = User::where('id', '=', $_SESSION['login'])->first();
                        $newRes->nomParticipant = $nom['login'];
                    }else{
                        $newRes->nomParticipant = $nomP;
                    }
                    $newRes->save();

                    if ($msg != ""){
                        $newMsg= new Message();
                        $newMsg->msg = "(Reservation) ".$msg;
                        $newMsg->liste_id = $liste_id;
                        if(isset($_SESSION['login'])) {
                            $nom = User::where('id', '=', $_SESSION['login'])->first();
                            $newMsg->auteur = $nom['login'];
                        }else{
                            $newMsg->auteur = $nomP;
                        }
                        $newMsg->save();
                    }

                    $url_items = $this->container->router->pathFor( 'aff_liste', ['token' => $_SESSION['token']] ) ;
                    return $rs->withRedirect($url_items);
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
        }else{
          $vue = new VueErreur( [] , $this->container ) ;
              $rs->getBody()->write( $vue->render( 0 ) ) ;
              return $rs;
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
