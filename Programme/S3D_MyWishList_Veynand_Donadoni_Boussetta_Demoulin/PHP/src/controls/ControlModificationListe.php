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
        session_start();

        $post = $rq->getParsedBody() ;
        $token = $_SESSION['token'];
        $no = $_SESSION['no'];
        if(!($token=='')){
            $i = Liste::where( 'no', '=', $no)->first() ;
            if($i->token==$token){
                $newT = filter_var($post['nouveautitre'],FILTER_SANITIZE_STRING);
                $newD = filter_var($post['nouvelledescription'],FILTER_SANITIZE_STRING);
                $newDa = filter_var($post['nouvelleecheance']);
                if ($newT == "") $newT =$i['titre'];
                if ($newD == "") $newD =$i['description'];
                if ($newDa == '') $newDa =$i['expiration'];
                $i->titre = $newT;
                $i->description = $newD;
                $i->expiration = $newDa;
                $i->update();
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
        $url_liste = $this->container->router->pathFor( 'aff_liste', ['no' => $_SESSION['no']] ) ;
        $rs->withRedirect($url_liste);
        return $rs;
    }


}
