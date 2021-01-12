<?php
declare(strict_types=1);

require 'vendor/autoload.php';

use \mywishlist\controls\ControlAccueil;
use \mywishlist\controls\ControlDeconnexionLogin;
use \mywishlist\controls\ControlCreationListe;
use \mywishlist\controls\ControlCreationLogin;
use \mywishlist\controls\ControlAffichageListe;
use \mywishlist\controls\ControlPartageURL;
use \mywishlist\controls\ControlConnexionLogin;
use \mywishlist\controls\ControlSupListe;
use \mywishlist\controls\ControlModificationListe;
use \mywishlist\controls\ControlAffichageItem;

$config = ['settings' => [
	'displayErrorDetails' => true,
]];

$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('src/conf/conf.ini')); //$db->addConnection(parse_ini_file('../../../conf.ini')); webetu
$db->setAsGlobal();
$db->bootEloquent();

$container = new \Slim\Container($config);
$app = new \Slim\App($container);

//racine
$app->get('/'          , ControlAccueil::class.':accueil'       )->setName('racine'    );


//liste
//affichage liste
$app->get('/listes'    , ControlAffichageListe::class.':afficherListes')->setName('aff_listes');
$app->get('/liste/{no}', ControlAffichageListe::class.':afficherListe' )->setName('aff_liste' );

//Creation liste
$app->get('/nouvelleliste' , ControlCreationListe::class.':formListe'  )->setName('formListe'  );
$app->post('/nouvelleliste' , ControlCreationListe::class.':newListe'  )->setName('newListe'  );

//Modification liste
$app->get('/choixmodifyListe' , ControlModificationListe::class.':choixmodifyListe'  )->setName('choixmodifyListe'  );
$app->post('/modifyListe' , ControlModificationListe::class.':modifyListe'  )->setName('modifyListe'  );

//Partage de la liste
$app->get('/share/{no}' , ControlPartageURL::class.':share'  )->setName('share'  );

//Supprimer liste
$app->get('/choixdeleteListe' , ControlSupListe::class.':choixdeleteListe'  )->setName('choixdeleteListe'  );
$app->post('/deleteListe' , ControlSupListe::class.':deleteListe'  )->setName('deleteListe'  );


//item
//affichage item
$app->get('/items' , ControlAffichageItem::class.':afficherItems'  )->setName('aff_items'  );
$app->get('/item/{id}' , ControlAffichageItem::class.':afficherItem'  )->setName('aff_item'  );
//Creation item
$app->get('/nouvelitem' , ControlCreationItem::class.':formItem'  )->setName('formItem'  );
$app->post('/nouvelitem' , ControlCreationItem::class.':newItem'  )->setName('newItem'  );

//Modification item
$app->get('/choixmodifyItem' , ControlCreationItem::class.':choixmodifyItem'  )->setName('choixmodifyItem'  );
$app->post('/modifyItem' , ControlCreationItem::class.':modifyItem'  )->setName('modifyItem'  );

//Supprimer item
$app->get('/choixdeleteItem' , ControlCreationItem::class.':choixdeleteItem'  )->setName('choixdeleteItem'  );
$app->post('/deleteItem' , ControlCreationItem::class.':deleteItem'  )->setName('deleteItem'  );


//login
//Creation login
$app->get('/formlogin' , ControlCreationLogin::class.':formlogin'  )->setName('formlogin'  );
$app->post('/nouveaulogin' , ControlCreationLogin::class.':nouveaulogin'  )->setName('nouveaulogin'  );

//Connexion login
$app->get('/testform' , ControlConnexionLogin::class.':testform'  )->setName('testform'  );
$app->post('/testpass' , ControlConnexionLogin::class.':testpass'  )->setName('testpass'  );

//Deconnexion login
$app->get('/deconnexion' , ControlDeconnexionLogin::class.':deconnexion'  )->setName('deconnexion'  );

$app->run();
