<?php
class UtilisateurController extends Controller
{

  function __construct()
  {
    parent::__construct();
  }

  function index(){
        $this->f3->set('view', 'main.html');
        $this->affichage();
  }

  /*Il il y a deux façon d'arriver ici.
   * Soit pour consulter son profil
   * Soit pour enregistrer les modifications apporté au profil
   * => consultation enregistrement modif
   */
  function monProfil($uidIn = null)
  {
    $user = new Utilisateur($this->db);
    $uid = $this->f3->get('PARAMS.uid');
    if(is_null($uid) && !is_null($uidIn))
    {
      $uid = $uidIn;
    }
    $profil = $user->getProfil($uid);
    $this->f3->set('datas', $profil);
    //ici il faudra vérifier la capacité a récupérer les id dans les checkbox
    $this->f3->set('amis', $profil->amis);
    $this->f3->set('SESSION.amis', $profil->amis);
    $this->f3->set("SESSION.user", $profil);
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
    $user->addFriend($this->f3->get('SESSION.user')->uid);
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
    $uid = $this->f3->get('POST.uid');
    // updateProfil($uid = null, $idGoogle = null, $pseudo, $nom,$prenom,$conditions = null,$email, $picto = null
    $user->updateProfil($uid, 
                    $this->f3->get('POST.Pseudo'),
                    $this->f3->get('POST.Nom'),
                    $this->f3->get('POST.Prenom'),
                    $this->f3->get('POST.Conditions'),
                    $this->f3->get('POST.email'));

    $this->monProfil($uid);
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
