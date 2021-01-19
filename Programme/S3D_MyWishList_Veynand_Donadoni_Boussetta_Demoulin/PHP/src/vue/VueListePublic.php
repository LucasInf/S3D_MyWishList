<?php
declare(strict_types=1);

namespace mywishlist\vue;


use mywishlist\models\Liste;

class VueListePublic
{
    private $tab;
    private $container;

    public function __construct($tab, $container) {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function verifPublic() : string {

        $url_modifyListe = $this->container->router->pathFor( 'passagePublic' ) ;
        session_start();
        $liste = Liste::where('no', '=', $_SESSION['no'])->first();
        if ($liste['public']){
            $qst = "en privé";
         }else{
            $qst = "en public";
        }
        $html = <<<FIN

    <form method="POST" action="$url_modifyListe">
    <h2>Passer la liste {$_SESSION['titre']} $qst ?</h2>
    <button type="submit">Passer la liste $qst</button>
</form>
FIN;
        return $html;
    }

    public function render( int $select ) : string {

        switch ($select) {
            case 1 : {
                $content = $this->verifPublic();
                break;
            }
        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;
        $url_deconnexion   = $this->container->router->pathFor( 'deconnexion'               ) ;


        $html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
    <title>Exemple</title>
    <link rel="stylesheet" href="../CSS/design.css" />
  </head>
  <body>
		<h1><a href="$url_accueil">Wish List</a></h1>
		<nav>
			<ul>
				<li><a href="$url_accueil">Accueil</a></li>
				<li><a href="$url_listes">Listes</a></li>
				<li><a href="$url_deconnexion">Deconnexion</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}