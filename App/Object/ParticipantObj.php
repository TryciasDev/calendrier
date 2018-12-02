<?php
class ParticipantObj {

	public $uid, $idGoogle, $nom, $prenom, $pseudo, $email, $picto, $conditions;
	public $amis;

	function __construct($i_nom, $i_prenom, $i_email,$i_pseudo) {
	    $this->nom = $i_nom;
	    $this->prenom = $i_prenom;
	    $this->pseudo = $i_pseudo;
	    $this->email = $i_email;
	}
	
	function setIdGoogle($i_idGoogle) {
	    $this->idGoogle = $i_idGoogle;
	}
	function setPicto($i_picto) {
	    $this->picto = $i_picto;
	}
	function setConditions($i_cond) {
	    $this->conditions = $i_cond;
	}
	function setUid($i_uid) {
	    $this->uid = $i_uid;
	}
	
	function setAmis($i_amis){
	    $this->amis = $i_amis;
	}
	
	function addAmi($i_ami){
	    $this->amis[]=$i_ami;
	}

	function get() {
	    return $this;
	}
}
