<?php
class CalendrierController extends Controller
{

  function __construct()
  {
    parent::__construct();
  }

  function getCalendrierAmi()
  {
    $calendrier = new Calendrier($this->db);
//    echo "<pre>"; var_dump($this->f3->get('SESSION.profil'));
//    die;
    $cal = $calendrier->getCalendrierAmi($this->f3->get('PARAMS.pseudo'),$this->f3->get('PARAMS.id'));
    $this->f3->set('datas', $cal);
    $this->f3->set('mode', 'ami');
    $this->f3->set('view', 'calendrier.html');
    $this->affichage();
  }

}
