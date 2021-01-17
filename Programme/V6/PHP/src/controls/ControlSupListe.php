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

        $post = $rq->getParsedBody();
        $token = $_SESSION['token'];
        $titre = $_SESSION['no'];
        if (!($token == '')) {
            $i = Liste::where('no', '=', $titre)->first();
            if ($i->token == $token) {
                $i->delete();
                $url_listes = $this->container->router->pathFor('aff_listes');
                $rs->withRedirect($url_listes);
            } else {
                echo "La liste n'a pas été trouvée car les informations données ne sont pas valides";
            }

        } else {
            echo "La liste n'a pas été trouvée car aucun token n'a été donné";
        }
        return $rs;
    }

    public function choixdeleteListe(Request $rq, Response $rs, $args): Response{
        $vue = new VueSupListe([], $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }

}