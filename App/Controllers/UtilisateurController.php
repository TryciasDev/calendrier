<?php
class UtilisateurController extends Controller
{

  function __construct()
  {
    parent::__construct();
  }

  function index(){
        $this->f3->set('view', 'HomepageView.php');
        $this->affichage();
  }

  function monProfil()
  {
    $user = new Utilisateur($this->db);
    $profil = $user->getProfil($this->f3->get('PARAMS.numero'));
    $this->f3->set('datas', $profil);
    $this->f3->set("SESSION.profil", $profil);
//$_SESSION['profil'] = $profil;
//    echo "<pre>"; var_dump($profil['fields']);
    $this->f3->set('mode', 'update');
    $this->f3->set('view', 'profil.html');
    $this->affichage();
  }

  function newProfilInvitation()
  {
    $this->f3->set('mode', 'invite');
    $this->f3->set('view', 'profil.html');
    $this->affichage();
  }

  function SendInvitation()
  {
    $user = new Utilisateur($this->db);
    $user->updateProfil(null, 
                                            $this->f3->get('POST.Pseudo'),
                                            $this->f3->get('POST.Nom'),
                                            $this->f3->get('POST.Prenom'),
                                            null,
                                            $this->f3->get('POST.email'));
    $user->addFriend($this->f3->get('PARAMS.id'));
/*
  todo 
    envoyer le mail
    récupérer le message ($this->f3->get('POST.Prenom'))
*/
    $this->monProfil();
  }

  function saveProfil()
  {
    //mettre à jours ou insérer dans réalisation
    $user = new Utilisateur($this->db);
    $user->updateProfil($this->f3->get('POST.numero'), 
                                            $this->f3->get('POST.Pseudo'),
                                            $this->f3->get('POST.Nom'),
                                            $this->f3->get('POST.Prenom'),
                                            $this->f3->get('POST.Conditions'),
                                            $this->f3->get('POST.email'));

    $this->monProfil();
  }



  function jourATraiter($dateParam)
  {
    $today = date("d");
    if(!is_null($dateParam) && $dateParam<$today)
    {
      return $dateParam;
    }
    return $today;
  }
}
