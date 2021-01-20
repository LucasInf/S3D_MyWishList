<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueCreationItem;
use \mywishlist\models\Item;

class ControlCreationItem
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    //permet de recupere les informations pour creer l'item
    public function formItem(Request $rq, Response $rs, $args) : Response {
        // pour afficher le formulaire item
        $vue = new VueCreationItem( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 1 ) ) ;
        return $rs;
    }

    //creer un item
    public function newItem(Request $rq, Response $rs, $args) : Response {
        // pour enregistrer 1 item.....
        session_start();
        $post = $rq->getParsedBody() ;

        $liste_id    = $_SESSION['no'] ;
        $nom     = filter_var($post['nom']       , FILTER_SANITIZE_STRING) ;
        $descr = filter_var($post['descr'] , FILTER_SANITIZE_STRING) ;
        $tarif = filter_var($post['tarif'] , FILTER_SANITIZE_NUMBER_INT) ;
        $l = new Item();
        $l->liste_id = $liste_id;
        $l->nom = $nom;
        $l->descr = $descr;
        $l->tarif = $tarif;
        $l->img=$_FILES["fileToUpload"]["name"];
        $l->save();

        $target_dir = "../img/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }


        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }


        if ($_FILES["fileToUpload"]["size"] > 50000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }


        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }


        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";

        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        $url_items = $this->container->router->pathFor( 'aff_liste', ['token' => $_SESSION['token']] ) ;
        return $rs->withRedirect($url_items);

    }
}
