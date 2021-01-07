<?php
declare(strict_types=1);

require 'vendor/autoload.php';

use \mywishlist\controls\MonControleur;
use \mywishlist\controls\ControlLogin;
use \mywishlist\controls\ControlCreationListe;
use \mywishlist\controls\ControlCreationLogin;

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
$app->get('/'          , MonControleur::class.':accueil'       )->setName('racine'    );

//liste
$app->get('/listes'    , MonControleur::class.':afficherListes')->setName('aff_listes');
$app->get('/liste/{no}', MonControleur::class.':afficherListe' )->setName('aff_liste' );

//Creation liste
$app->get('/nouvelleliste' , ControlCreationListe::class.':formListe'  )->setName('formListe'  );
$app->post('/nouvelleliste' , ControlCreationListe::class.':newListe'  )->setName('newListe'  );

//item
//Creation item

//login

//Creation login
$app->get('/formlogin' , ControlCreationLogin::class.':formlogin'  )->setName('formlogin'  );
$app->post('/nouveaulogin' , ControlCreationLogin::class.':nouveaulogin'  )->setName('nouveaulogin'  );

$app->get('/testform' , ControlLogin::class.':testform'  )->setName('testform'  );
$app->post('/testpass' , ControlLogin::class.':testpass'  )->setName('testpass'  );

$app->get('/deconnexion' , ControlLogin::class.':deconnexion'  )->setName('deconnexion'  );

$app->run();
