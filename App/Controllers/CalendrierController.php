<?php
class CalendrierController extends Controller
{

  function __construct()
  {
    parent::__construct();
  }

  function addDefi()
  {
    //$this->f3->set('mode', 'insert');
    $defi = $this->f3->get('POST.defi');
    $victimeId = $this->f3->get('POST.victimeId');
    $auteurId = $this->f3->get('POST.auteurId');
    $idEvent = $this->f3->get('POST.idEvent');
    $jour = $this->f3->get('PARAMS.jour');


    $mapper = new Utilisateur($this->db);
    $victime = $mapper->getProfilSimple($victimeId);
    $auteur = $mapper->getProfilSimple($auteurId);
    $event = new Evenement($this->db);
    $jourCible = new DateTime('201812'.$jour);
    $isSaved = $event->saveDefi($auteurId,$victimeId, $defi,$jourCible, $idEvent);
    var_dump($isSaved);
die;
    $event->getEvent($isSaved->idEvent);

/*
    if($event != '') {
      $this->f3->set('event', $event);
      $this->f3->set('mode', 'update');
    }
    $this->f3->set('numeroJour', $jour);
    $this->f3->set('auteur', $auteur);
    $this->f3->set('victime', $victime);
    $this->f3->set('mode', 'ami');
    $this->f3->set('view', 'calendrierForm.html');
*/
  //  $this->affichage();
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
    $user = new Utilisateur($this->db);
    $victimeId = $this->f3->get('PARAMS.ami');
    $victime = $user->getProfilSimple($victimeId);
    $jours = $this->prepareListDays();
    $weekDays = $this->prepareListweekdays();
    $nbDefisTotal = $calendrier->getNbDefiByDay($victimeId);
    $cal = $calendrier->getCalendrierAmi($victimeId,$this->f3->get('PARAMS.id'));
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
    $this->f3->set('ami', $victime);
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
