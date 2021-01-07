<?php
declare(strict_types=1);

require 'vendor/autoload.php';

use \mywishlist\controls\MonControleur;
use \mywishlist\controls\ControlLogin;

$config = ['settings' => [
	'displayErrorDetails' => true,
]];

$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('src/conf/conf.ini')); //$db->addConnection(parse_ini_file('../../../conf.ini')); webetu
$db->setAsGlobal();
$db->bootEloquent();

$container = new \Slim\Container($config);
$app = new \Slim\App($container);

$app->get('/'          , MonControleur::class.':accueil'       )->setName('racine'    );
$app->get('/listes'    , MonControleur::class.':afficherListes')->setName('aff_listes');

$app->get('/liste/{no}', MonControleur::class.':afficherListe' )->setName('aff_liste' );

$app->get('/nouvelleliste' , MonControleur::class.':formListe'  )->setName('formListe'  );
$app->post('/nouvelleliste' , MonControleur::class.':newListe'  )->setName('newListe'  );

$app->get('/nouvelitem' , MonControleur::class.':formItem'  )->setName('formItem'  );
$app->post('/nouvelitem' , MonControleur::class.':newItem'  )->setName('newItem'  );

$app->get('/formlogin' , ControlLogin::class.':formlogin'  )->setName('formlogin'  );
$app->post('/nouveaulogin' , ControlLogin::class.':nouveaulogin'  )->setName('nouveaulogin'  );

$app->get('/testform' , MonControleur::class.':testform'  )->setName('testform'  );
$app->post('/testpass' , MonControleur::class.':testpass'  )->setName('testpass'  );

$app->get('/deconnexion' , MonControleur::class.':deconnexion'  )->setName('deconnexion'  );

$app->get('/share/{no}' , MonControleur::class.':share'  )->setName('share'  );

$app->run();
