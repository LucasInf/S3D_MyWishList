<?php

declare(strict_types=1);

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\vue\VueAffichageItem;
use \mywishlist\models\Item;

class ControlAffichageItem
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }



    public function afficherItem(Request $rq, Response $rs, $args) : Response {
        $item = Item::find( $args['id'] ) ;
        $vue = new VueAffichageItem( [ $item->toArray() ] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 2 ) ) ;
        return $rs;
    }

    public function changeImage(Request $rq, Response $rs, $args) : Response {
        session_start();
        $l = Item::where( 'id', '=', $_SESSION['idItem'])->first();
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
            $l->img=$_FILES["fileToUpload"]["name"];
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }


        $l->update();
        $url_items = $this->container->router->pathFor( 'aff_liste', ['token' => $_SESSION['token']] ) ;
        return $rs->withRedirect($url_items);
    }
}