<?php
class HomepageController extends Controller
{

  function __construct()
  {
    parent::__construct();
  }

  function index(){
        $this->f3->set('view', 'HomepageView.php');
        $this->affichage();
  }

  function getJour()
  {
    $event = new Evenement($this->db);
    $day = $this->jourATraiter($this->f3->get('PARAMS.day'));
    $this->f3->set('datas', $event->listBydayAndVictim($day, 'Pat'));
    $this->f3->set('view', 'jour.php');
    $this->affichage();
  }

  function retourDefi()
  {
    //mettre à jours ou insérer dans réalisation
    $real = new Realisation($this->db);
    $idEvent = $this->f3->get('PARAMS.idEvent');
    $commentaire = $this->f3->get('PARAMS.commentaire');
    $isDone = $this->f3->get('PARAMS.isDone');
    $real->addRealisation($idEvent,$commentaire);

    $event = new Evenement($this->db);
    $event->updateRealisation($idEvent,$isDone);
    $this->getJour();
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
