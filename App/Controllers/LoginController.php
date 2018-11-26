<?php
class LoginController extends Controller
{

	function index()
	{
        $f3=Base::instance();
        $this->f3=$f3;
		$this->f3->set('view', 'login.html');
		echo \Template::instance()->render('layout.html','text/html');
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

}