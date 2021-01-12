<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueModificationListe;
use \mywishlist\models\Liste;

class ControlModificationListe
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function choixmodifyListe(Request $rq, Response $rs, $args): Response{
        $vue = new VueModificationListe([], $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }

    public function modifyListe(Request $rq, Response $rs, $args): Response{
        $post = $rq->getParsedBody() ;
        $token   = filter_var($post['token']       , FILTER_SANITIZE_STRING) ;
        $titre    = filter_var($post['nom']       , FILTER_SANITIZE_STRING) ;
        if(!($token=='')){
            $i = Liste::where( 'titre', 'LIKE', $titre)->first() ;
            if($i->token==$token){
                $newD = filter_var($_POST['nouvelledescription'],FILTER_SANITIZE_STRING);
                $i->description = $newD;
                $i->update();
            }else{
                echo "La liste n'a pas été trouvée car les informations données ne sont pas valides";
            }

        }else{
            echo "La liste n'a pas été trouvée car aucun token n'a été donné";
        }
        $url_listes = $this->container->router->pathFor( 'aff_listes' ) ;
        $rs->withRedirect($url_listes);
        return $rs;
    }


}