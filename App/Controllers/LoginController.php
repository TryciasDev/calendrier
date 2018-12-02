<?php
class LoginController extends Controller
{

	function index()
	{
		$connexions['google']['Libelle'] = "Google";
		$connexions['google']['url'] = "http://calendrieravent.faitparpatricia.fr/auth/google";
		$connexions['google']['logo'] = 'https://developers.google.com/identity/images/btn_google_signin_light_normal_web_short.png';
		$this->f3->set('datas', $connexions);
        $this->f3->set('view', 'appelConnexion.html');
        $this->affichage();
	}

	function landing($datas)
	{

		$user = new Utilisateur($this->db);
		$numeroGoogle = $datas['uid'];
		$email = $datas['raw']['email'];
		$pseudo = $datas['raw']['name'];
		$prenom = $datas['raw']['given_name'];
		$nom = $datas['raw']['family_name'];
		$picto = $datas['raw']['picture'];
		$session = $user->getProfilGoogle($numeroGoogle);
		

		if(is_null($session->uid)){
		    $searchInvite = $user->getByEmail($email);
		    if(is_null($searchInvite->uid)){
		        $user->updateProfil(null,$numeroGoogle, $pseudo, $nom, $prenom, null, $email, $picto);
		        $session = $user->getProfilGoogle($numeroGoogle);
		    } else {
		        $user->updateProfil($searchInvite->uid,$numeroGoogle, $pseudo, $nom, $prenom, null, $email, $picto);
		        $session = $user->getProfilGoogle($numeroGoogle);
		    }
		}

		$amis = $session->amis ;
		$this->f3->set('SESSION.user', $session);
		$this->f3->set('amis', $amis);
		$this->f3->set('jour', date('d'));
        $this->f3->set('uid', $session->uid);
        $this->f3->reroute('MonProfil/'.$session->uid);
//        $this->f3->set('view', 'main.html');
        
//        $this->affichage();
  	}
  	
  	
  	function logout() {
  	    $this->f3->set('jour', date('d'));
  	    $this->f3->set('SESSION.user', null);
  	    $this->f3->set('view', 'main.html');
  	    $this->f3->reroute('/');
  	}

}