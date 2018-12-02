<?php
class CalendrierController extends Controller
{

  function __construct()
  {
    parent::__construct();
  }

  function index()
  {
      $calendrier = new Calendrier($this->db);
      $jours = $this->prepareListDays();
      $victimeId = $this->f3->get('SESSION.user')->uid;
      $nbDefisTotal = $calendrier->getNbDefiByDay($victimeId);
      $cal = $calendrier->getCalendrier($victimeId);
      
      foreach ($nbDefisTotal as  $nb)
      {
          $jours[$nb['numeroJour']-1]['nbDefiTotal'] = $nb['compteur'];
      }
      foreach ($cal as  $event)
      {
          if($event['numeroJour']<=date(d))
          {
              $jours[$event['numeroJour']-1]['defis'][] = array('desc'=> $event['description'],
                  'auteur'=>$event['pseudoAuteur'],
                  'idAuteur'=>$event['uidAuteur'],
                  'commentaireVictime'=>$event['comment'],
                  'dateRealisation'=>$event['date'],
                  'idEvent'=>$event['idEvenement']);
          }
          $jours[$event['numeroJour']-1]['nbDefi'] = $jours[$event['numeroJour']-1]['nbDefi']+1 ;
      }
      shuffle($jours);
      $weekDays = array();
      $iterator = 0;
      for($i =0; $i <6; $i++)
      {
          for($j=0; $j<4;$j++)
          {
              $weekDays[$i][$j]=$jours[$iterator];
              $iterator++;
          }
      }
      $this->f3->set('datas', $weekDays);
      $this->f3->set('jour', date(d));
      $this->f3->set('view', 'main.html');
      $this->affichage();
  }

  function getJour()
  {
      $event = new Evenement($this->db);
      $day = $this->jourATraiter($this->f3->get('PARAMS.day'));
      $this->f3->set('datas', $event->listBydayAndVictim($day, 'Pat'));
      $this->f3->set('view', 'jour.html');
      $this->affichage();
  }
  
  function retourDefi()
  {
      //mettre à jours ou insérer dans réalisation
      $real = new Realisation($this->db);
      $idEvent = $this->f3->get('PARAMS.idEvent');
      $commentaire = $this->f3->get('PARAMS.commentaire');
      $real->addRealisation($idEvent,$commentaire);
      
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

    $return_array = array('idEvent' => $isSaved[0]['idEvent'],
                            'victime' => $isSaved[0]['victime'],
                            'auteur' => $isSaved[0]['auteur'],
                            'jour' =>  $jour,
                            'auteurNom' => $auteur->pseudo,
                            'defi' => $isSaved[0]['description']
      );
    echo json_encode($return_array);
  

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
    //$weekDays = $this->prepareListweekdays();
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
                                                        'idAuteur'=>$event['uidAuteur'],
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
	  return array(1,2,3,4,5,6);
  }
  function prepareListDays()
  {
    $jours  = array();
    $colors = $this->getColors();
    for($i=1 ; $i < 25 ; $i ++)
    {
      $current = new DateTime('12/'.$i.'/'.date('Y'));
      $jours[$i-1]["date"] = $current->format('d/m/Y');
      $jours[$i-1]["day"] = $current->format('d');
      $jours[$i-1]["numeroDuJour"] = $current->format('w');
      $jours[$i-1]['nbDefi'] = 0;
      $jours[$i-1]['nbDefiTotal'] = 0;
      $jours[$i-1]['colors'] = $colors[array_rand($colors)] ;
    }
    return $jours;
  }

  function getColors()
  {
      $colors[] = 'dark';
      $colors[] = 'secondary';
      $colors[] = 'danger';
      $colors[] = 'success';
      $colors[] = 'warning';
      $colors[] = 'info';
      return $colors;
  }
  
}
