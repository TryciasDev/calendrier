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
        $requete ="select md5(concat(count(1)+2, UNIX_TIMESTAMP())) as uid from participants";
        $id = $this->db->exec($requete);
        return $id[0]['uid'];        
    }
	
	function updateProfil($uid = null, $idGoogle = null, $pseudo, $nom,$prenom,$conditions = null,$email, $picto = null)
	{
		$participant = new DB\SQL\Mapper($this->db, 'participants');
		if(!is_null($uid)){
			$participant->load(array('uid=?',$uid));
			$participant->uid = $uid;
		} elseif(!is_null($idGoogle)){
		    $participant->load(array('idGoogle=?',$idGoogle));
		    $participant->idGoogle = $idGoogle;
		}
		if(is_null($uid))
		{
		    $participant->uid = $this->getNouvelIdentifiant();
		}
		$participant->pseudo = $pseudo;
		$participant->nom = $nom;
		$participant->prenom = $prenom;
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
		return $this->mapUtilisateur($participant);
	}
	
	function mapUtilisateur($participant) {
	    if(is_array($participant)){
	        $obj = new ParticipantObj($participant['nom'], $participant['prenom'], $participant['email'], $participant['pseudo']);
	        $obj->setIdGoogle($participant['idGoogle']);
	        $obj->setUid($participant['uid']);
	        $obj->setConditions($participant['conditions']);
	    } else {
	        $obj = new ParticipantObj($participant->nom, $participant->prenom, $participant->email, $participant->pseudo);
	        $obj->setIdGoogle($participant->idGoogle);
	        $obj->setUid($participant->uid);
	        $obj->setConditions($participant->conditions);
	    }
	    return $obj;
	}
	function addAmitieInvite($id1, $id2)
	{
	    $amis = new DB\SQL\Mapper($this->db, 'amis');
	    $amis->load(array("user1 = ? and user2 = ?",$amis->user1, $amis->user2));
	    $amis->user1 = $id1;
	    $amis->user2 = $id2;
	    $amis->save();
	}

	function getAmis($id)
	{
		$requete ="select uid, pseudo, nom, prenom, email from participants".
							" join amis liens1 on liens1.user1 = participants.uid".
							" where liens1.user2 = ?".
							" union".
							" select uid, pseudo, nom, prenom, email from participants".
							" join amis liens2 on liens2.user2 = participants.uid".
							" where liens2.user1 = ?";
		$listeIdAmis = $this->db->exec($requete, array($id, $id));
		return $listeIdAmis;
	}

	function getProfil($id)
	{
		$participant = $this->getProfilSimple($id);
		$amis = $this->getAmis($id);
		$obj = $this->mapUtilisateur($participant);
		foreach ($amis as $ami){
		    $objTmp = $this->mapUtilisateur($ami);
		    $obj->addAmi($objTmp);
		}
		return $obj;
	}
	function getByEmail($email)
	{
		$participant = new DB\SQL\Mapper($this->db, 'participants');
		$participant->load(array('upper(email)=?',strtoupper($email)));
		return $this->mapUtilisateur($participant);
	}
	function getProfilSimple($id)
	{
	    $participant = new DB\SQL\Mapper($this->db, 'participants');
	    $participant->load(array('uid=?',$id));
	    return $this->mapUtilisateur($participant);
	}
	function getProfilGoogle($id)
	{
		$participant = new DB\SQL\Mapper($this->db, 'participants');
		$participant->load(array('idGoogle=?',$id));
		$obj = $this->mapUtilisateur($participant);
		$amis = $this->getAmis($obj->uid);
		foreach ($amis as $ami){
		    $objTmp = $this->mapUtilisateur($ami);
		    $obj->addAmi($objTmp);
		}
		return $obj ;
	}
}
