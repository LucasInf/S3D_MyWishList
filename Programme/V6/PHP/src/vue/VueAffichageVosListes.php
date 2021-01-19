<?php
declare(strict_types=1);

namespace mywishlist\vue;


class VueAffichageVosListes
{
    private $tab;
    private $container;

    public function __construct($tab, $container)
    {
        $this->tab = $tab;
        $this->container = $container;

    }

    private function vosListes(): string
    {
        $html = '';
        $html .= "<h2>Vos Wish Listes :</h2>";
        session_start();
        foreach ($this->tab as $liste) {
            if ($liste['user_id'] == $_SESSION['login']){
                $url_liste = $this->container->router->pathFor('aff_liste', ['token' => $liste['token']]);

                if ($liste['public']){
                    $pub = "PUBLIC";
                }else {
                    $pub = "PRIVE";
                }

                $html .= "<li><a href='$url_liste'>{$liste['titre']}</a> <strong>$pub</strong></li>";
            }

        }
        $html = "<ul>$html</ul>";
        return $html;
    }

    public function render( int $select ) : string
    {

        switch ($select) {
            case 1 :
            { // liste des listes
                $content = $this->vosListes();
                break;
            }
        }

        $url_accueil    = $this->container->router->pathFor( 'racine'                 ) ;
        $url_listes     = $this->container->router->pathFor( 'aff_listes'             ) ;


        $html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
    <title>Exemple</title>
    <link rel="stylesheet" href="CSS/design.css" />
  </head>
  <body>
		<h1><a href="$url_accueil">Wish List</a></h1>
		<nav>
			<ul>
				<li><a href="$url_accueil">Accueil</a></li>
				<li><a href="$url_listes">Listes</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
FIN;
        return $html;
    }

}