<?php

namespace Veranstalter\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceManager;
use Zend\Session\Container;

class EventTable {
	private $serviceLocator;
	private $tableGateway;
	private $event;
	private $organizerID;
	
	public function __construct(ServiceManager $serviceLocator, $dbName) {
		$this->serviceLocator = $serviceLocator;
		
		$dbNameIdentifier = new \Zend\Db\Sql\TableIdentifier ( $dbName );
		
		$dbAdapter = $this->serviceLocator->get ( 'Zend\Db\Adapter\Adapter' );
		
		$this->tableGateway = new \Zend\Db\TableGateway\TableGateway ( $dbNameIdentifier, $dbAdapter, null, null );
		
		$buffer = new Container ( 'eventSession' );
		try {
			$this->event = $buffer->offsetGet ( 'event' );
		} catch ( \Exception $e ) {
			return $e;
		}
		$buffer = new Container ('userSession');
		$organizer = $buffer->offsetGet('organizer');
		$this->organizerID = $organizer->getOrganizer_ID();

	}
	public function saveEvent() {
		$set = $this->eventObjectToSaveableArray ( $this->event );
		try {
			$this->tableGateway->insert ( $set );
		} catch ( Exception $e ) {
			return $e;
		}
		
		return $set;
	}
	public function loadEvent ($eventID) {
		//
		$rowset = $this->tableGateway->select ( array (
				'event_ID' => $eventID 
		) );
		$row = $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find the eventID $eventID" );
		}
		return $row;
	}
	
	public function getAllOrganizerEvents () {
		$returnArr = array ();
		
		$rowset = $this->tableGateway->select ( array (
				'organizer_ID' => $this->organizerID 
		) );
		
		
		
		if (! $rowset) {
			throw new \Exception ( "Could not find organizerID $organizerID" );
		}
		
		for($i = 0; $i < $rowset->count (); $i ++) {
			$buffer = $rowset->current ();
			$event = new Event ();
			$event->loadEvent ( $this->serviceLocator, $buffer ["event_ID"] );
			array_push ( $returnArr, $event );
			$rowset->next ();
		}
		
		return $returnArr;
	}
	
	private function filterRestrictionData($data) {
		return array (
				'ageclass_ID' => 1,
				'age' => $data ["age"],
				'genderfemale' => $data ["female"],
				'gendermale' => $data ["male"],
				'championship' => $data ["championship"],
				'company' => $data ["company"]
		);
	}
	
	public function updateRestrictions($data) {
		
		$rowset = $this->tableGateway->update ( $this->filterRestrictionData($data), array (
				'restriction_ID' => $this->event->getRestrictionID () 
		) );
		if (!$rowset)
			return false;
		
		return true;
	}
	
	/**
	 * gibt ein asso.
	 * Array zurück
	 */
	public function eventObjectToSaveableArray(Event $e) {
		return array (
				
				// 'event_ID' => $e->getEventID(),
				'organizer_ID' => $e->getOrganizerID (),
				'sports_ID' => $e->getSportsID (),
				'restriction_ID' => $e->getRestrictionID (),
				'uploadevent_ID' => $e->getUploadeventID (),
				'label_ID' => $e->getLabelID (),
				'cashback_ID' => $e->getCashbackID (),
				'previousevent_ID' => $e->getPreviouseventID (),
				'postcode_ID' => $e->getPostcodeID (),
				'name' => $e->getName (),
				'streetaddress' => $e->getAdress (),
				'housenumber' => $e->getHouseNumber (),
				'entryfee' => $e->getEntryfee (),
				'description' => $e->getDescription (),
				'limitation' => $e->getLimitation (),
				'rating_ID' => $e->getRatingID (),
				'status' => $e->getStatus () 
		);
	}
	
	public function setEvent (Event $event) {
		$this->event = $event;
	}
}


