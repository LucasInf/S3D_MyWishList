<?php
declare(strict_types=1);

require 'vendor/autoload.php';

use \mywishlist\controls\ControlAccueil;
use mywishlist\controls\ControlAffichageCreateur;
use \mywishlist\controls\ControlDeconnexionLogin;
use \mywishlist\controls\ControlCreationListe;
use \mywishlist\controls\ControlCreationLogin;
use \mywishlist\controls\ControlAffichageListe;
use mywishlist\controls\ControlListePublic;
use \mywishlist\controls\ControlPartageURL;
use \mywishlist\controls\ControlConnexionLogin;
use \mywishlist\controls\ControlSupListe;
use \mywishlist\controls\ControlModificationListe;
use \mywishlist\controls\ControlAffichageItem;
use \mywishlist\controls\ControlCreationItem;
use \mywishlist\controls\ControlModificationItem;
use \mywishlist\controls\ControlSupItem;
use \mywishlist\controls\ControlAjouterMessageListe;
use \mywishlist\controls\ControlReserverItem;
use \mywishlist\controls\ControlAjoutImage;
use \mywishlist\controls\ControlModifyImage;
use \mywishlist\controls\ControlDeleteImage;
use \mywishlist\controls\ControlModifyLogin;
use \mywishlist\controls\ControlSupLogin;


$config = ['settings' => [
	'displayErrorDetails' => true,
]];

$db = new \Illuminate\Database\Capsule\Manager();

$db->addConnection(parse_ini_file('../../../conf.ini')); // lucas
//$db->addConnection(parse_ini_file('../../../../conf.ini')); //nael

$db->setAsGlobal();
$db->bootEloquent();

$container = new \Slim\Container($config);
$app = new \Slim\App($container);

//racine
$app->get('/'          , ControlAccueil::class.':accueil'       )->setName('racine'    );


//liste
//affichage liste
$app->get('/listes'    , ControlAffichageListe::class.':afficherListes')->setName('aff_listes');
$app->get('/liste/{token}', ControlAffichageListe::class.':afficherListe' )->setName('aff_liste' );
$app->get('/voslistes'    , ControlAffichageListe::class.':afficherVosListes')->setName('aff_voslistes');

//Creation liste
$app->get('/nouvelleliste' , ControlCreationListe::class.':formListe'  )->setName('formListe'  );
$app->post('/nouvelleliste' , ControlCreationListe::class.':newListe'  )->setName('newListe'  );

//Modification liste
$app->get('/choixmodifyListe/{token}' , ControlModificationListe::class.':choixmodifyListe'  )->setName('choixmodifyListe'  );
$app->post('/modifyListe' , ControlModificationListe::class.':modifyListe'  )->setName('modifyListe'  );

//Partage de la liste
$app->get('/share/{token}' , ControlPartageURL::class.':share'  )->setName('share'  );

//Supprimer liste
$app->get('/choixdeleteListe/{token}' , ControlSupListe::class.':choixdeleteListe'  )->setName('choixdeleteListe'  );
$app->post('/deleteListe' , ControlSupListe::class.':deleteListe'  )->setName('deleteListe'  );

//Ajouter un message
$app->get('/ajouterMessageListe/{token}', ControlAjouterMessageListe::class.':ajoutMessageliste')->setName('ajoutMessageliste');
$app->post('/ajouterMessageListe', ControlAjouterMessageListe::class.':newMessage')->setName('newMessage');

//Passer la liste en public
$app->get('/passerListePublic/{token}', ControlListePublic::class.':verifPublic')->setName('verifPublic');
$app->post('/passerListePublic', ControlListePublic::class.':passagePublic')->setName('passagePublic');

//item
//affichage item
$app->get('/items' , ControlAffichageItem::class.':afficherItems'  )->setName('aff_items'  );
$app->get('/item/{id}' , ControlAffichageItem::class.':afficherItem'  )->setName('aff_item'  );
//Creation item
$app->get('/nouvelitem' , ControlCreationItem::class.':formItem'  )->setName('formItem'  );
$app->post('/nouvelitem' , ControlCreationItem::class.':newItem'  )->setName('newItem'  );

//Modification item
$app->get('/choixmodifyItem/{id}' , ControlModificationItem::class.':choixmodifyItem'  )->setName('choixmodifyItem'  );
$app->post('/modifyItem' , ControlModificationItem::class.':modifyItem'  )->setName('modifyItem'  );

//Supprimer item
$app->get('/choixdeleteItem/{id}' , ControlSupItem::class.':choixdeleteItem'  )->setName('choixdeleteItem'  );
$app->post('/deleteItem' , ControlSupItem::class.':deleteItem'  )->setName('deleteItem'  );

//Ajout image item
$app->get('/choixajoutImage' , ControlAjoutImage::class.':choixajoutImageItem'  )->setName('choixajoutImage'  );
$app->post('/ajoutImage' , ControlAjoutImage::class.':AjoutImageItem'  )->setName('ajoutImage'  );

//Modification image item
$app->get('/choixmodifyImage' , ControlModifyImage::class.':choixmodifyImage'  )->setName('choixmodifyImage'  );
$app->post('/modifyImage' , ControlModifyImage::class.':modifyImage'  )->setName('modifyImage'  );

//Suppression image item
$app->get('/choixdeleteImage' , ControlDeleteImage::class.':choixdeleteImage'  )->setName('choixdeleteImage'  );
$app->post('/deleteImage' , ControlDeleteImage::class.':deleteImage'  )->setName('deleteImage'  );

//Reserver item
$app->get('/choixreserverItem/{id}' , ControlReserverItem::class.':choixreserverItem'  )->setName('choixreserverItem'  );
$app->post('/reserverItem' , ControlReserverItem::class.':reserverItem'  )->setName('reserverItem'  );


//login
//Creation login
$app->get('/formlogin' , ControlCreationLogin::class.':formlogin'  )->setName('formlogin'  );
$app->post('/nouveaulogin' , ControlCreationLogin::class.':nouveaulogin'  )->setName('nouveaulogin'  );

//Modification login
$app->get('/choixmodifylogin' , ControlModifyLogin::class.':choixmodifylogin'  )->setName('choixmodifylogin'  );
$app->post('/modifylogin' , ControlModifyLogin::class.':modifylogin'  )->setName('modifylogin'  );

//Suppression login
$app->get('/choixsuplogin' , ControlSupLogin::class.':choixsuplogin'  )->setName('choixsuplogin'  );
$app->post('/suplogin' , ControlSupLogin::class.':suplogin'  )->setName('suplogin'  );

//Connexion login
$app->get('/testform' , ControlConnexionLogin::class.':testform'  )->setName('testform'  );
$app->post('/testpass' , ControlConnexionLogin::class.':testpass'  )->setName('testpass'  );

//Deconnexion login
$app->get('/deconnexion' , ControlDeconnexionLogin::class.':deconnexion'  )->setName('deconnexion'  );

//Afficher createur
$app->get('/affichageCreateur' , ControlAffichageCreateur::class.':afficherCreateur'  )->setName('aff_createur'  );

$app->run();
