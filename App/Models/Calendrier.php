<?php
class Calendrier extends DB\SQL\Mapper {
	// Instantiate mapper
	function __construct(DB\SQL $db) {
		// This is where the mapper and DB structure synchronization occurs
		parent::__construct($db,'evenements');
	}


	function getCalendrierAmi($id, $numero)
	{

		$requete ="SELECT evenements.*, realisations.*, participants.identifiant, participants.numero ".
					" FROM evenements".
					" left join realisations on realisations.idEvent = evenements.idEvent ".
					" left join lienUsers lien1 on lien1.user1 = evenements.author".
					" left join lienUsers lien2 on lien2.user2 = evenements.author".
					" join participants on participants.numero = evenements.author".
					" WHERE target = :ami and (lien1.user2 = :user or lien2.user1 = :user or evenements.author = :user)".
					" ORDER by evenements.jour";
		$params = array('ami'=>$id, 
						'user' => $numero);
		echo "<pre>";
		var_dump($params);
		$listeEvent = $this->db->exec($requete, $params);
		var_dump($listeEvent);
die;
		//return $this->find(array());
		return $listeIdAmis;
	}
/*
ALTER TABLE Orders
ADD FOREIGN KEY (PersonID) REFERENCES Persons(PersonID);
*/
}
