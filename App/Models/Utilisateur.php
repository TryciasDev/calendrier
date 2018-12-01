<?php
class Utilisateur extends DB\SQL\Mapper {
	// Instantiate mapper
	function __construct(DB\SQL $db) {
		// This is where the mapper and DB structure synchronization occurs
		parent::__construct($db,'participants');
	}
	/*
	 * Génére un id en créer le md5 du nombre de participant
	 */
    function  getNouvelIdentifiant()
    {
        $requete ="select md5(count(1)+1) from participants";
        $id = $this->db->exec($requete);
        var_dump($id);
        die;
        return $id;        
    }
	
	function updateProfil($uid = null, $idGoogle = null, $pseudo, $nom,$prenom,$conditions = null,$email, $picto = null)
	{
		$participant = new DB\SQL\Mapper($this->db, 'participants');
		if(!is_null($uid)){
			$participant->load(array('uid=?',$uid));
			$participant->uid = $uid;
		} elseif(!is_null($idGoogle)){
		    $participant->load(array('idGoogle=?',$idGoogle));
		    $participant->idGoogle = $uid;
		}
		if(is_null($uid))
		{
		    $participant->uid = $this->getNouvelIdentifiant();
		}
		$participant->pseudo = $pseudo;
		$participant->Nom = $nom;
		$participant->Prenom = $prenom;
		$participant->email = $email;
		if(!is_null($conditions))
		{
			$participant->conditions = $conditions;
		}
		if(!is_null($picto))
		{
			$participant->picto = $picto;
		}
		$participant->save();
		/*if(!is_null($id)){
			$participant->uid = $participant->get('uid'); 
		}*/
		return $participant;
	}

	function getAmis($id)
	{

		$requete ="select uid, pseudo, nom, prenom from participants".
							" join amis liens1 on liens1.user1 = participants.uid".
							" where liens1.user2 = ?".
							" union".
							" select uid, pseudo, nom, prenom from participants".
							" join amis liens2 on liens2.user2 = participants.uid".
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
	function getByEmail($email)
	{
		$participant = new DB\SQL\Mapper($this->db, 'participants');
		$participant->load(array('email=?',$email));
		return $participant;
	}
	function getProfilSimple($id)
	{
	    $participant = new DB\SQL\Mapper($this->db, 'participants');
	    $participant->load(array('uid=?',$id));
	    return $participant;
	}
	function getProfilGoogle($id)
	{
		$participant = new DB\SQL\Mapper($this->db, 'participants');
		$participant->load(array('idGoogle=?',$id));
		return $participant;
	}

	function getUserByMail($email)
	{
		$participant = new DB\SQL\Mapper($this->db, 'participants');
		$participant->load(array('email=?',$email));
		return $participant;
	}

}
