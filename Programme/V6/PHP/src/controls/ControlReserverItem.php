<?php

declare(strict_types=1);

namespace mywishlist\controls;

use mywishlist\model\Reservation;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueReserverItem;
use \mywishlist\models\Item;

class ControlReserverItem
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function reserverItem(Request $rq, Response $rs, $args) : Response {
          $post = $rq->getParsedBody() ;
          $liste_id    = filter_var($post['liste_id']       , FILTER_SANITIZE_NUMBER_INT) ;
          $id     = filter_var($post['id']       , FILTER_SANITIZE_STRING) ;
          $nomP     = filter_var($post['nomP']       , FILTER_SANITIZE_STRING);
          $token = random_bytes(25);
          $token = bin2hex($token);

          if(!($liste_id==null)){
              $i = Item::where( 'id', '=', $id) ->first() ;
              $newRes = Reservation::where( 'idReservation', '=', $id) ->first() ;
              if($i->liste_id==$liste_id){
                  if($newRes->idReservation == null){
                      $newRes = new Reservation();
                      $newRes->idReservation = $token;
                      $newRes->idItem = $i->id;
                      $newRes->nomParticipant= $nomP;
                      $newRes->update();
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

      }

      public function choixreserverItem(Request $rq, Response $rs, $args): Response{
          $vue = new VueWish([], $this->container);
          $rs->getBody()->write($vue->render(0));
          return $rs;
      }


}
