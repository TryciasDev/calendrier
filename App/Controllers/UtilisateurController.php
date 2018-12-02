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

  function getUid($uidIn = null) {
      $uidUrl = $this->f3->get('PARAMS.uid');
      $uidSession = $this->f3->get('SESSION.user')->uid;
      if(!is_null($uidSession) && is_string($uidSession) && strlen(trim($uidSession))>20)
      {
          return $uidSession;
      } elseif (!is_null($uidIn) && is_string($uidIn) && strlen(trim($uidIn))>20){
          return $uidIn;
      }
      
      return $uidUrl;
  }
  /*Il il y a deux façon d'arriver ici.
   * Soit pour consulter son profil
   * Soit pour enregistrer les modifications apporté au profil
   * => consultation enregistrement modif
   */
  function monProfil($uidIn = null)
  {
    $user = new Utilisateur($this->db);
    $uid = $this->getUid($uidIn);
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
    $invite = $user->updateProfil(null, null,
                $this->f3->get('POST.Pseudo'),
                $this->f3->get('POST.Nom'),
                $this->f3->get('POST.Prenom'),
                null,
                $this->f3->get('POST.email'));
    $inviteur = $this->f3->get('SESSION.user')->uid;
    $listAmis = $this->f3->get('POST.amis');
    foreach ($listAmis as $amis){
//        echo $amis." // ".$inviteur;
        if($amis != $inviteur) {
            $user->addAmitieInvite($amis, $inviteur);
        }
    }
    
    $this->sendInvitationMail($this->f3->get('POST.email'), $this->f3->get('POST.message'), $this->f3->get('POST.Pseudo'));
    
/*
  todo 
    envoyer le mail
    récupérer le message ($this->f3->get('POST.email'))
*/
    
    $this->monProfil($inviteur);
  }

  
  function sendInvitationMail($email, $msg,$pseudoInvite)
  {
      $mail=new SMTP('ssl0.ovh.net',465,'SSL',$this->f3->get('mailFrom'),$this->f3->get('pwdMail'));
      $mail->set('from',$this->f3->get('mailFrom'));
      $mail->set('to',$email);
      $mail->set('pseudoInvite',$email);
      $mail->set('subject',$this->f3->get('objMailInvite'));
      $mail->send(Template::instance()->render('email.txt'));
  }
  
  function saveProfil()
  {
    //mettre à jours ou insérer dans réalisation
    $user = new Utilisateur($this->db);
    $uid = $this->f3->get('POST.uid');
    $profil = $user->updateProfil($uid, null,
                    $this->f3->get('POST.Pseudo'),
                    $this->f3->get('POST.Nom'),
                    $this->f3->get('POST.Prenom'),
                    $this->f3->get('POST.Conditions'),
                    $this->f3->get('POST.email'));
    $listAmis = $this->f3->get('POST.amis');
    foreach ($listAmis as $amis){
        $user->addAmitie($amis);
    }
    if($profil instanceof ParticipantObj) {
        $this->monProfil($uid);
    } else {
        $this->f3->set('erreur', $profil);
        $this->f3->set('view', 'profil.html');
        $this->affichage();
    }
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
