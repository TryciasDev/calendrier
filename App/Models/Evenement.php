<?php
class Evenement extends DB\SQL\Mapper {
	// Instantiate mapper
	function __construct(DB\SQL $db) {
		// This is where the mapper and DB structure synchronization occurs
		parent::__construct($db,'evenements');
	}

	// Specialized query
	function listBydayAndVictim($day,$victime) {
		return $this->find(array('day(jour) = ? and target = ?', $day, $victime));
	}
	function getEvent($idEvent) {
		if(is_null($idEvent)) return false;
		return $this->find(array('idEvent = ?', $idEvent));
	}
	function updateRealisation($idEvent,$isDone)
	{
		$real = new DB\SQL\Mapper($this->db, 'evenements');
		$real->idEvent = $idEvent;
		$real->isDone = $isDone;
		$real->save();
	}

	function deleteDefi($idEvent)
	{
		$defi = new DB\SQL\Mapper($this->db, 'evenements');
		$defi->load(array('idEvent = ?', $idEvent));
		//var_dump($defi);die;
		$result = $defi->erase(array('idEvent = ?', $idEvent));
	}
}
