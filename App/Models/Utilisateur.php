<?php
class Utilisateur extends DB\SQL\Mapper {
	// Instantiate mapper
	function __construct(DB\SQL $db) {
		// This is where the mapper and DB structure synchronization occurs
		parent::__construct($db,'participants');
	}


	function updateProfil($id,$pseudo, $nom,$prenom,$conditions = null,$email)
	{
		$participant = new DB\SQL\Mapper($this->db, 'participants');
		//var_dump($id);die;
		if(!is_null($id)){
			$participant->load(array('numero=?',$id));
		}
		$participant->identifiant = $pseudo;
		$participant->Nom = $nom;
		$participant->Prenom = $prenom;
		$participant->email = $email;
		if(!is_null($conditions))
		{
			$participant->Conditions = $conditions;
		}
		$participant->save();
		if(!is_null($id)){
			$participant->numero = $participant->get('numero'); 
		}
		return $participant;
	}
	function getAmis($id)
	{

		$requete ="select numero, identifiant, nom, prenom from participants".
							" join lienUsers liens1 on liens1.user1 = participants.numero".
							" where liens1.user2 = ?".
							" union".
							" select numero, identifiant, nom, prenom from participants".
							" join lienUsers liens2 on liens2.user2 = participants.numero".
							" where liens2.user1 = ?";
		$listeIdAmis = $this->db->exec($requete, array($id, $id));
		//return $this->find(array());
		return $listeIdAmis;
	}

	function getProfil($id)
	{
		$participant = $this->getProfilSimple($id);
		$participant->amis = $this->getAmis($id);
		return $participant;
	}
	function getProfilSimple($id)
	{
		$participant = new DB\SQL\Mapper($this->db, 'participants');
		$participant->load(array('numero=?',$id));
		return $participant;
	}

	function getUserByMail($email)
	{
		$participant = new DB\SQL\Mapper($this->db, 'participants');
		$participant->load(array('email=?',$email));
		return $participant;
	}

}
