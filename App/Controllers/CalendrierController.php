<?php
class CalendrierController extends Controller
{

  function __construct()
  {
    parent::__construct();
  }

  function addDefi()
  {
    $this->f3->set('mode', 'insert');
    $mapper = new Utilisateur($this->db);
    $victime = $mapper->getProfilSimple($this->f3->get('PARAMS.victime'));
    $auteur = $mapper->getProfilSimple($this->f3->get('PARAMS.auteur'));
    $event = new Evenement($this->db);
    $event->getEvent($this->f3->get('PARAMS.idEvent'));
    if($event) {
      $this->f3->set('event', $event);
      $this->f3->set('mode', 'update');
    }

    $this->f3->set('numeroJour', $this->f3->get('PARAMS.jour'));
    $this->f3->set('auteur', $auteur);
    $this->f3->set('victime', $victime);
    $this->f3->set('mode', 'ami');
    $this->f3->set('view', 'calendrierForm.html');
    $this->affichage();
  }

  function deleteDefi()
  {
    // ce serait cool de faire cette methode en ajax
    $event = new Evenement($this->db);
    $event->deleteDefi($this->f3->get('PARAMS.idEvent'));
    $this->getCalendrierAmi();
  }

  function getCalendrierAmi()
  {
    $calendrier = new Calendrier($this->db);
    $jours = $this->prepareListDays();
    $weekDays = $this->prepareListweekdays();
    $nbDefisTotal = $calendrier->getNbDefiByDay($this->f3->get('PARAMS.ami'));
    $cal = $calendrier->getCalendrierAmi($this->f3->get('PARAMS.ami'),$this->f3->get('PARAMS.id'));
    foreach ($nbDefisTotal as  $nb)
    {
      $jours[$nb['numeroJour']-1]['nbDefiTotal'] = $nb['compteur'];
    } 
    foreach ($cal as  $event) 
    {
      $jours[$event['numeroJour']-1]['nbDefi'] = $jours[$event['numeroJour']-1]['nbDefi']+1 ;
      $jours[$event['numeroJour']-1]['defis'][] = array('desc'=> $event['description'], 
                                                        'auteur'=>$event['pseudoAuteur'],
                                                        'idAuteur'=>$event['numero'],
                                                        'isDone'=>$event['isDone'],
                                                        'commentaireVictime'=>$event['comment'],
                                                        'dateRealisation'=>$event['date'],
                                                        'idEvent'=>$event['idEvenement']);
    }
    //echo "<pre>"; var_dump($jours); die;
    $this->f3->set('auteur', $this->f3->get('PARAMS.id'));
    $this->f3->set('ami', $this->f3->get('PARAMS.ami'));
    $this->f3->set('datas', $jours);
    $this->f3->set('mode', 'ami');
    $this->f3->set('view', 'calendrierAmi.html');
    $this->affichage();
  }

  function prepareListweekdays()
  {
	  return array(1,2,3,4,5,6,7);
  }
  function prepareListDays()
  {
    $jours  = array();
    for($i=1 ; $i < 25 ; $i ++)
    {
      $current = new DateTime('12/'.$i.'/'.date('Y'));
      $jours[$i-1]["date"] = $current->format('d/m/Y');
      $jours[$i-1]["numeroDuJour"] = $current->format('w');
      $jours[$i-1]['nbDefi'] = 0;
      $jours[$i-1]['nbDefiTotal'] = 0;
    }
    return $jours;
  }

}
