<?php
class Calendrier extends DB\SQL\Mapper {
	// Instantiate mapper
	function __construct(DB\SQL $db) {
		// This is where the mapper and DB structure synchronization occurs
		parent::__construct($db,'evenements');
	}

	function getCalendrierAmi($id, $numero)
	{

		$requete ="SELECT day(evenements.jour) as numeroJour, ".
					" evenements.idEvent as idEvenement, ".
					" evenements.*, ".
					" realisations.*,".
					" participants.identifiant as pseudoAuteur,".
					" participants.numero ".
					" FROM evenements".
					" left join realisations on realisations.idEvent = evenements.idEvent ".
					" left join lienUsers lien1 on lien1.user1 = evenements.author".
					" left join lienUsers lien2 on lien2.user2 = evenements.author".
					" join participants on participants.numero = evenements.author".
					" WHERE target = :ami and (lien1.user2 = :user or lien2.user1 = :user or evenements.author = :user)".
					" ORDER by evenements.jour";
		$params = array('ami'=>$id, 
						'user' => $numero);
		$listeEvent = $this->db->exec($requete, $params);
		//return $this->find(array());
//    echo "<pre>"; var_dump($listeEvent);
//    die;
		return $listeEvent;
	}

	function getNbDefiByDay($id)
	{
		$requete = "select day(evenements.jour) as numeroJour, count(1) as compteur from evenements".
					" where target = :ami".
					" group by jour";
		$params = array('ami'=>$id);
		$listeEvent = $this->db->exec($requete, $params);
		return $listeEvent;
	}
/*
ALTER TABLE Orders
ADD FOREIGN KEY (PersonID) REFERENCES Persons(PersonID);
*/
}
