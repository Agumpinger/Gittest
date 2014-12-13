<?php

namespace Veranstalter\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Zend\ServiceManager\ServiceManager;

use Zend\Session\Container;

class AllocationTable {
	private $serviceLocator;
	private $tableGateway;
	private $event;
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
	}
	public function sportsIDload() {
	}
	public function loadRestrictions() {
		$returnArr = array ();
		
		$rowset = $this->tableGateway->select ( array (
				'restriction_ID' => $this->event->getRestrictionID () 
		) );
		
		// $row = $rowset->current();
		
		if (! $rowset) {
			return "Rowset could not be loaded. Request aborted.";
		}
		
		return $rowset->current ();
	}
	public function loadAgeClassByID($ageClassID) {
		$rowset = $this->tableGateway->select ( array (
				'ageclass_ID' => $ageClassID 
		) );
		
		if (! $rowset) {
			return "Rowset could not be loaded. Request aborted.";
		}
		
		return $rowset->current ();
	}
	public function loadLabelsByID() {
		$rowset = $this->tableGateway->select ( array (
				'label_ID' => $this->event->getLabelID () 
		) );
		
		if (! $rowset) {
			return array ();
		}
		
		return $rowset->current ();
	}
	
	
	/**
	 *
	 * @param
	 *        	default event object is Session Event
	 */
	public function setEvent(Event $event) {
		$this->event = $event;
	}
}