<?php

namespace Veranstalter\Model;

class Allocation {
	private $restrictionArray;
	private $serviceLocator;
	public function __construct($serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	public function sportsIDtoString($seriveLocator) {
		// kann noch nicht verwendet werden, da die sports tabelle hinten und vorne nicht stimmt
		/*
		 * $sm = $seriveLocator;
		 *
		 * $dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
		 *
		 * $tableGateway = new \Zend\Db\TableGateway\TableGateway ( 'sportsid', $dbAdapter, null, null );
		 *
		 * $eventTable = new EventTable ( $tableGateway );
		 * $list = $eventTable->getAllOrganizerEvents($organizerID, $serviceLocator);
		 * return $list;
		 * $allocTable = new AllocationTable($tableGateway);
		 */
	}
	public function loadEventRestrictions() {
		$restrictionStandards = $this->getRestrictionStandards ();
		$restriction = array ();
		
		$counter = 0;
		$ageCounter = 0;
		
		$restrTable = new AllocationTable ( $this->serviceLocator, "restriction" );
		
		$ageclassTable = new AllocationTable ( $this->serviceLocator, "ageclass" );
		// Hier wird
		if (is_string ( ($buffer = $restrTable->loadRestrictions ()) ))
			return $buffer;
		else if (! $buffer)
			return $restriction;
		
		foreach ( $buffer as $element ) {
			$text = $restrictionStandards [$counter] . "";
			$restriction [$text] = $element;
			$counter ++;
		}
		
		if (is_string ( ($buffer = $ageclassTable->loadAgeClassByID ( $restriction ["restrictionID"] )) ))
			return $restriction;
		else if (! $buffer)
			return array ();
		
		foreach ( $buffer as $element ) {
			if (! ($ageCounter == 0)) {
				
				$text = $restrictionStandards [$counter] [$ageCounter - 1] . "";
				$restriction [$text] = $element;
			}
			$ageCounter ++;
		}
		
		return $restriction;
	}
	/**
	 * Gibt alle labels eines events zurück
	 *
	 * @return label Array
	 */
	public function loadEventLabels() {
		$counter = 0;
		$labelStandards = $this->getLabelStandards ();
		
		$labelArray = array ();
		
		$buffer = array ();
		
		$labelTable = new AllocationTable ( $this->serviceLocator, 'label' );
		// 1 mit Session Event abändern später
		$buffer = $labelTable->loadLabelsByID ();
		
		foreach ( $buffer as $element ) {
			if (! ($counter == 0)) {
				$text = $labelStandards [$counter - 1] . "";
				
				if ($element == 1)
					$labelArray [$text] = true;
				else
					$labelArray [$text] = false;
			}
			$counter ++;
		}
		return $labelArray;
	}
	// Wird angelegt, um später mit einem asso. Array arbeiten zu können
	private function getRestrictionStandards() {
		return array (
				'restrictionID',
				'ageclassID',
				'age',
				'genderfemale',
				'gendermale',
				'championship',
				'company',
				$this->getAgeClassStandards()
		);
	}
	
	private function getAgeClassStandards() {
		return array (
				'name',
				'startage',
				'endage' 
		);
	}
	
	public static function getLabelStandards() {
		return array (
				'greenstar',
				'health',
				'performance',
				'fun',
				'women',
				'beginner',
				'championship',
				'kids',
				'youth' 
		);
	}
}