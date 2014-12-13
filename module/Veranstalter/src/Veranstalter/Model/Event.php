<?php

namespace Veranstalter\Model;

use Veranstalter\Model\EventTable;

class Event {
	private $eventID;
	private $organizerID;
	private $sportsID;
	private $restrictionID;
	private $uploadeventID;
	private $labelID;
	private $cashbackID;
	private $previouseventID;
	private $postcodeID;
	private $name;
	private $adress;
	private $houseNumber; // ????
	private $entryfee;
	private $description;
	private $limitation;
	private $ratingID;
	private $status;
	public function __construct() {
		$this->eventID = 0;
		$this->organizerID = 0;
		$this->sportsID = 0;
		$this->restrictionID = 0;
		$this->uploadeventID = 0;
		$this->labelID = 0;
		$this->cashbackID = 0;
		$this->previouseventID = 0;
		$this->postcodeID = 0;
		$this->name = "";
		$this->adress = "";
		$this->houseNumber = 0;
		$this->entryfee = 0;
		$this->description = "";
		$this->limitation = 0;
		$this->ratingID = 0;
		$this->status = "";
	}
	public function saveEvent($serviceLocator) {
		$eventTable = new EventTable ( $serviceLocator, 'event' );
		return $eventTable->saveEvent ( $this );
	}
	public function updateAllValues($data) {
		$this->name = $data ["name"];
		$this->sportsID = $data ["sport"];
		$this->restrictionID = $data ["resid"];
		$this->uploadeventID = $data ["upid"];
		$this->labelID = $data ["labid"];
		$this->previouseventID = $data ["previd"];
		$this->postcodeID = $data ["postid"];
		$this->adress = $data ["adr"];
		$this->houseNumber = $data ["hounr"];
		$this->entryfee = $data ["fee"];
		$this->description = $data ["descr"];
		$this->limitation = $data ["lim"];
	}

	public function updateRestrictions($serviceLocator, $data) {
		$eventTable = new EventTable($serviceLocator, 'restriction');
		if ($eventTable->updateRestrictions($data))
			return true;
		else
			return false;		
	}
	
	public function updateLabels() {
	}
	
	public function loadEvent($serviceLocator, $eventID) {
		$details = array ();
		
		$eventTable = new EventTable ( $serviceLocator, 'event' );
		$details = $eventTable->loadEvent ( $eventID );
		
		if (! empty ( $details )) {
			$this->setEventID ( $details ["event_ID"] );
			$this->setOrganizerID ( $details ["organizer_ID"] );
			$this->setSportsID ( $details ["sports_ID"] );
			$this->setRestrictionID ( $details ["restriction_ID"] );
			$this->setUploadeventID ( $details ["uploadevent_ID"] );
			$this->setLabelID ( $details ["label_ID"] );
			$this->setCashbackID ( $details ["cashback_ID"] );
			$this->setPreviouseventID ( $details ["previousevent_ID"] );
			$this->setPostcodeID ( $details ["postcode_ID"] );
			$this->setName ( $details ["name"] );
			$this->setAdress ( $details ["streetaddress"] );
			$this->setHouseNumber ( $details ["housenumber"] );
			$this->setEntryfee ( $details ["entryfee"] );
			$this->setDescription ( $details ["description"] );
			$this->setLimitation ( $details ["limitation"] );
			$this->setRatingID ( $details ["rating_ID"] );
			$this->setStatus ( $details ["status"] );
			return true;
		} else {
			throw new \Exception ( "Der Ladevorgang war nicht erfolgreich." );
		}
	}
	public function getEventList () {
		$eventTable = new EventTable ( $this->table );
	}
	public static function getAllOrganizerEvents($serviceLocator) {			
		$eventTable = new EventTable ( $serviceLocator, 'event' );
		
		return $eventTable->getAllOrganizerEvents ();
	}
	public function getEventID() {
		return $this->eventID;
	}
	public function setEventID($eventID) {
		$this->eventID = $eventID;
	}
	public function getOrganizerID() {
		return $this->organizerID;
	}
	public function setOrganizerID($organizerID) {
		$this->organizerID = $organizerID;
	}
	public function getSportsID() {
		return $this->sportsID;
	}
	public function setSportsID($sportsID) {
		$this->sportsID = $sportsID;
	}
	public function getRestrictionID() {
		return $this->restrictionID;
	}
	public function setRestrictionID($restrictionID) {
		$this->restrictionID = $restrictionID;
	}
	public function getUploadeventID() {
		return $this->uploadeventID;
	}
	public function setUploadeventID($uploadeventID) {
		$this->uploadeventID = $uploadeventID;
	}
	public function getLabelID() {
		return $this->labelID;
	}
	public function setLabelID($labelID) {
		$this->labelID = $labelID;
	}
	public function getCashbackID() {
		return $this->cashbackID;
	}
	public function setCashbackID($cashbackID) {
		$this->cashbackID = $cashbackID;
	}
	public function getPreviouseventID() {
		return $this->previouseventID;
	}
	public function setPreviouseventID($previouseventID) {
		$this->previouseventID = $previouseventID;
	}
	public function getPostcodeID() {
		return $this->postcodeID;
	}
	public function setPostcodeID($postcodeID) {
		$this->postcodeID = $postcodeID;
	}
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
	}
	public function getAdress() {
		return $this->adress;
	}
	public function setAdress($adress) {
		$this->adress = $adress;
	}
	public function getHouseNumber() {
		return $this->houseNumber;
	}
	public function setHouseNumber($houseNumber) {
		$this->houseNumber = $houseNumber;
	}
	public function getEntryfee() {
		return $this->entryfee;
	}
	public function setEntryfee($entryfee) {
		$this->entryfee = $entryfee;
	}
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
	}
	public function getLimitation() {
		return $this->limitation;
	}
	public function setLimitation($limitation) {
		$this->limitation = $limitation;
	}
	public function getRatingID() {
		return $this->ratingID;
	}
	public function setRatingID($ratingID) {
		$this->ratingID = $ratingID;
	}
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
}