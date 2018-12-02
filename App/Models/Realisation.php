<?php
class Realisation extends DB\SQL\Mapper {
	// Instantiate mapper
	function __construct(DB\SQL $db) {
		// This is where the mapper and DB structure synchronization occurs
		parent::__construct($db,'realisations');
	}


	function addRealisation($idEvent,$comment)
	{
		$real = new DB\SQL\Mapper($db, 'realisations');
		$real->idEvent = $idEvent;
		$real->comment = $comment;
//		$real->date = date("Ymd");
		$real->save();
	}
	// Specialized query
	function listBydayAndVictim($day,$victime) {
		//return 'hahaha';
		return $this->find(array('day(jour) = ? and victime = ?', $day, $victime));
		//return $this->find('vendorID,name,city',null,array('order'=>'city DESC'));
		/*
		We could have done the same thing with plain vanilla SQL:
		return $this->db->exec(
			'SELECT vendorID,name,city FROM vendors '.
			'ORDER BY city DESC;'
		);
		*/
	}
}
