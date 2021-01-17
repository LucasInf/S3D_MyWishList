<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueAjoutImage;
use \mywishlist\models\Item;

class ControlAjoutImage
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function AjoutImageItem(Request $rq, Response $rs, $args): Response{
        $post = $rq->getParsedBody() ;
        $liste_id    = filter_var($post['liste_id']       , FILTER_SANITIZE_NUMBER_INT) ;
        $nom     = filter_var($post['nom']       , FILTER_SANITIZE_STRING) ;
        $img    = filter_var($post['img']       , FILTER_SANITIZE_STRING) ;
        if(!($liste_id==null)){
            $i = Item::where( 'nom', 'LIKE', $nom) ->first() ;
            if($i->liste_id==$liste_id){
                $i->img = $img;
                $i->update();
                $url_items = $this->container->router->pathFor( 'aff_items' ) ;
                return $rs->withRedirect($url_items);
            }else{
                echo "L'item n'a pas été trouvé car les informations données ne sont pas valides";
            }

        }else{
            echo "L'item n'a pas été trouvé car aucun identifiant de liste n'a été donné";
        }

    }



}

