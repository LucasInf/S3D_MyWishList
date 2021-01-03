<?php

require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\models\Item;
use \mywishlist\models\Liste;

$db = new DB();
$db->addConnection(
parse_ini_file('src/conf/conf.ini'));
//$db->addConnection(parse_ini_file('../../../conf.ini')); webetu


$db->setAsGlobal();
$db->bootEloquent();

echo "<H2>Les listes </H2>";
$listes = Liste::get();
//var_dump($l);
foreach($listes as $l) {
    echo "NO : $l->no, TITRE : $l->titre, DESC $l->description <br>";
}

echo "<br>";


echo "<h2>Les items</h2>";
// indiquer le nom de la liste de souhait dans la liste des items
$items = Item::all();
foreach($items as $it) {
    echo "{$it->id} {$it->liste_id} {$it->nom} {$it->descr} <b>{$it->liste->titre}</b><br>";
}

echo "<h2>Les Items de la Liste 4</h2>";
// lister les items d'une liste donnée dont l'id est passé en paramètre.
$l = Liste::find(4);
//$items = $l->items()->get();
$items = $l->items;
//var_dump($items);
foreach($items as $it) {
    echo "{$it->id} {$it->liste_id} {$it->nom} {$it->descr}<br>";
}



$id = (int) $_GET['id'];
echo "<br>";
echo "<H2>L'items N°$id </H2>";
$it = Item::where('id', '=', $id)->first();
//$it = Item::find($id);

echo "ID : $it->id, TITRE : $it->liste_id, NOM $it->nom, DESC $it->descr <br>";

echo "<H2>Insertion</H2>";
$ins = new Item() ;
$ins->liste_id = 4;
$ins->nom = 'Test';
$ins->descr = 'test ins';
$ins->save() ;


$id = $ins->id;
$it = Item::find($id);
echo "{$it->id} {$it->liste_id} {$it->nom} {$it->descr}<br>";

echo"<h2>Les Items de la liste 4</h2>";
$l = Liste::find(4);
$items = $l->items;
foreach($items as $it2) {
    echo "ID : $it2->id, TITRE : $it2->liste_id, NOM $it2->nom, DESC $it2->descr <br>";
}

echo"<h2>La liste de l'item 3</h2>";
$item = Item::find(3);
$lis = $item->liste;

echo "NO : $lis->no, TITRE : $lis->titre, DESC $lis->description <br>";


/*
$l1 = new Liste();
$l1->titre = 'test';
$l1->save();
*/
