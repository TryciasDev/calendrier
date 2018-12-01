<?php
class Calendrier extends DB\SQL\Mapper {
	// Instantiate mapper
	function __construct(DB\SQL $db) {
		// This is where the mapper and DB structure synchronization occurs
		parent::__construct($db,'evenements');
	}

	function getCalendrierAmi($id, $uid)
	{

		$requete ="SELECT day(evenements.jour) as numeroJour, ".
					" evenements.idEvent as idEvenement, ".
					" evenements.description, ".
					" evenements.victime as idVictime, ".
					" evenements.auteur, ".
					" realisations.comment,".
					" realisations.date,".
					" participants.pseudo as pseudoAuteur,".
					" participants.uid as uidAuteur".
					" FROM evenements".
					" left join realisations on realisations.idEvent = evenements.idEvent ".
					" left join amis lien1 on lien1.user1 = evenements.auteur".
					" left join amis lien2 on lien2.user2 = evenements.auteur".
					" join participants on participants.uid = evenements.auteur".
					" WHERE victime = :ami and (lien1.user2 = :user or lien2.user1 = :user or evenements.auteur = :user)".
					" ORDER by evenements.jour";
		$params = array('ami'=>$id, 
						'user' => $uid);
		$listeEvent = $this->db->exec($requete, $params);
		return $listeEvent;
	}

	function getNbDefiByDay($id)
	{
		$requete = "select day(evenements.jour) as numeroJour, count(1) as compteur from evenements".
					" where victime = :ami".
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
