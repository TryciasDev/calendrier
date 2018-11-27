<?php
class LoginController extends Controller
{

	function index()
	{
    	$callback_website_url='http://calendrierAvent.faitparPatricia.com/google_landing.php';
		$this->googleAuthenticate($callback_website_url);

	}

	function submitLogin()
	{
		F3::route('GET /login',
		function() {
		$openid=new OpenID;
		$openid->identity='https://www.google.com/accounts/o8/id';
		$openid->return_to=F3::get('PROTOCOL').'://'.$_SERVER.'/verified';
		}
		);
		F3::route('GET /verified',
		function() {
		$openid=new OpenID;
		echo $openid->verified()?'Success':'Failure';
		}
		);
		F3::run(); 
		
	}
	function landingGoogle()
	{
		// il faudra vérifier dans quel ordre arrive les paramétres
		//cela dit ils doivent surement arriver de façon nommé
		/*
		$param1 = $this->f3->get('PARAMS.param1');
		$param2 = $this->f3->get('PARAMS.param2');
		$param3 = $this->f3->get('PARAMS.param4');
		*/
		$param1 = $this->f3->get('GET.openid_ext1_value_firstname');
		$param2 = $this->f3->get('GET.openid_ext1_value_lastname');
		$param3 = $this->f3->get('GET.openid_ext1_value_email');

		if($this->verifParam($param1) && $this->verifParam($param2) && $this->verifParam($param3))
		{
			$user = new Utilisateur;
			$user->getUserByMail($param3);
			if(!isset($user->getIdentifiant))
			{
				$nouveauUser = $user->updateProfil($param1, $param2,$param1,null,$param3);
				$this->f3->reroute('/MonProfil/'.$nouveauUser->numero);
			}
		}
	}

	function verifParam($param)
	{
		if(is_null($param)) return false;
		if(empty($param)) return false;
		return true;
	}
	function googleAuthenticate($callback_website_url) {
    $openid = new lightopenid;
    $openid->identity = 'https://www.google.com/accounts/o8/id';
    $openid->returnUrl = $callback_website_url;
    $endpoint = $openid->discover('https://www.google.com/accounts/o8/id');
    $fields ='?openid.ns=' . urlencode('http://specs.openid.net/auth/2.0') .
		'&openid.return_to=' . urlencode($openid->returnUrl) .
		'&openid.claimed_id=' . urlencode('http://specs.openid.net/auth/2.0/identifier_select') .
		'&openid.identity=' . urlencode('http://specs.openid.net/auth/2.0/identifier_select') .
		'&openid.mode=' . urlencode('checkid_setup') .
		'&openid.ns.ax=' . urlencode('http://openid.net/srv/ax/1.0') .
		'&openid.ax.mode=' . urlencode('fetch_request') .
		'&openid.ax.required=' . urlencode('email,firstname,lastname') .
		'&openid.ax.type.firstname=' . urlencode('http://axschema.org/namePerson/first') .
		'&openid.ax.type.lastname=' . urlencode('http://axschema.org/namePerson/last') .
		'&openid.ax.type.email=' . urlencode('http://axschema.org/contact/email');
		header('location:'.$endpoint . $fields);            
}

}