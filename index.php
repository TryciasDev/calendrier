<?php
require_once("vendor/autoload.php");
$f3 = Base::instance();

$f3->config('App/Config/setup.cfg');
$f3->config('App/Config/routes.cfg');
$f3->config('App/Config/opauth.ini', TRUE);
//new Session();
// init with config
$opauth = OpauthBridge::instance($f3->opauth);

// define login handler
$opauth->onSuccess('LoginController->landing');
/*
$opauth->onSuccess(function($datas){
		$f3 = Base::instance();
        $db=new DB\SQL(
            $f3->get('devdb'),
            $f3->get('devdbusername'),
            $f3->get('devdbpassword'),
            array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
			);
        
		$user = new Utilisateur($db);
		$numero = $datas['uid'];
		$email = $datas['raw']['email'];
		$pseudo = $datas['raw']['name'];
		$prenom = $datas['raw']['given_name'];
		$nom = $datas['raw']['family_name'];
		$picto = $datas['raw']['picture'];
		$utilisateur = $user->updateProfil($numero, $pseudo, $nom, $prenom, null, $email, $picto);

		$session = $user->getProfil($numero);
		$f3->set('SESSION.user', $session);
		$f3->set('SESSION.test1', 'Azerty');

  	    $f3->set('view', 'main.html');
  	    $amis = $f3->get("SESSION.user")->amis ;
var_dump($f3->get("SESSION"));
        $f3->set('amis', $amis);
        $f3->set('numero', $numero);
        echo \Template::instance()->render('layout.html','text/html');
});
*/
// define error handler
$opauth->onAbort(function($data){
	header('Content-Type: text');
	echo 'Une erreur est survenue lors de votre connexion.'."\n";
	print_r($data);
});

$f3->run();
